<?php

namespace App\Http\Controllers;

use App\Models\MDataBooking;
use App\Models\MDataRuangRapat;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;

class UserCT extends Controller
{
    public function index(Request $request)
    {
        Carbon::setLocale('id');

        $allRoom = MDataRuangRapat::with('gedung')->get();

        if ($request->date == null) {
            $dateSet = Carbon::now()->format('d-m-Y');
            $day = Carbon::now()->translatedFormat('l');
        } else {
            $dateSet = $request->date;
            $day = Carbon::parse($request->date)->translatedFormat('l');
        }

        return view('user/dashboard', [
            'title' => 'SIRARA | Dashboard',

            'listRuang' => $allRoom,
            'day' => $day,
            'dateSet' => $dateSet
        ]);
    }

    public function booking(Request $request)
    {
        $room = MDataRuangRapat::where('uuid', $request->uuid)->firstOrFail();
        return view('user.booking', [
            'title' => 'SIRARA | Booking',
            'data' => $room
        ]);
    }

    public function _booking(Request $request)
    {
        try {
            Carbon::setLocale('id');

            $ruang = MDataRuangRapat::where('uuid', $request->uuid)->get(['id', 'ruang', 'lokasi', 'kampus'])->first();

            $request->validate([
                'nama' => 'required|string',
                'nomor_hp' => 'required|string|max:14',
                'nama_rapat' => 'required|string',
                'pesan' => 'nullable|string',
                'tanggal' => 'required|date',
                'waktu' => 'required|string|max:1',
            ]);


            $code = Carbon::now()->format('ymd');
            switch ($request->waktu) {
                case '1':
                    $code = $code . 'A';
                    break;
                case '2':
                    $code = $code . 'B';
                    break;
                case '3':
                    $code = $code . 'C';
                    break;
                default:
                    return back()->with('error', 'Terdapat kesalahan dalam mengurai waktu');
                    break;
            }

            $code = $code . $ruang->id . Str::upper(Str::random(2));

            $booking = new MDataBooking();

            $booking->uuid = Str::uuid();
            $booking->kode = $code;
            $booking->nama = $request->nama;
            $booking->no_hp = $request->nomor_hp;
            $booking->agenda_rapat = $request->nama_rapat;
            $booking->tanggal = Carbon::createFromFormat('d-m-Y', $request->tanggal)->format('Y-m-d');
            $booking->uuid_ruang = $request->uuid;
            $booking->kode_waktu = $request->waktu;
            $booking->status = 'none';

            $booking->save();

            $pesan = $request->pesan != '' ? $request->pesan : '-';
            $tanggal = Carbon::parse($request->tanggal)->translatedFormat('d F Y');
            switch ($request->waktu) {
                case '1':
                    $waktu = 'Pagi (08:00) - Siang (12:00)';
                    break;
                case '2':
                    $waktu = 'Siang (12:00) - Sore (15:00)';
                    break;
                case '3':
                    $waktu = 'Pagi (08:00) - Sore (15:00)';
                    break;
                default:
                    $waktu = 'Terdapat kesalahan dalam mengurai waktu';
                    break;
            }

            $message = "*=== BOOKING BARU ===*\n*Kode: " . $code . "*\nNama: " . $request->nama . "\nNo. HP: " . $request->nomor_hp . "\nAgenda Rapat: " . $request->nama_rapat . "\n\nRuang: " . $ruang->ruang . "\nLokasi: " . $ruang->lokasi . " (Kampus " . $ruang->kampus . ")\nTanggal: " . $tanggal . "\nWaktu: " . $waktu . "\n\n*Pesan: " . $pesan . "*\n\nHarap Segera Melakukan Konfirmasi\nLink/Detail: " . route('admin.booking.detail', ['uuid' => Str::uuid()]);
            $custMessage = "*=== INFORASI BOOKING ===*\nInformasi booking Anda sedang diproses, silahkan tunggu konfirmasi dari pihak admin.\n\nKode Booking: " . $code . "\nNama: " . $request->nama . "\nAgenda Rapat: " . $request->nama_rapat . "\n\nRuang: " . $ruang->ruang . "\nLokasi: " . $ruang->lokasi . " (Kampus " . $ruang->kampus . ")\nTanggal: " . $tanggal . "\nWaktu: " . $waktu . "\n\nJika ingin melakukan pembatalan harap lakukan pada link berikut\nhttps://google.com/";
            // dd($custMessage);
            // dd($message);

            $this->sendToNo($request->nomor_hp, $custMessage);
            $this->sendToNo(ENV('API_WA_ADMIN'), $message);
            // $this->sendToGroup($message);

            return back()->with('success', 'Berhasil melakukan booking, silahkan tunggu konfirmasi dari pihak rumah tangga.');
            // dd($message);
        } catch (ValidationException $e) {
            return back()->with('error', 'Terdapat kesalahan pada input form');
        } catch (\Exception $err) {
            // dd($err);
            return back()->with('error', 'Terdapat kesalahan ketika melakukan proses booking');
        }
    }

    private function sendToNo($to, $message)
    {
        $dataSending = array();
        $dataSending["api_key"] = ENV('API_KEY');
        $dataSending["number_key"] = ENV('API_NO_KEY');
        $dataSending["phone_no"] = $to;
        $dataSending["message"] = $message;
        // $dataSending["wait_until_send"] = "1";
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://api.watzap.id/v1/send_message',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => json_encode($dataSending),
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json'
            ),
        ));

        $response = curl_exec($curl);
        curl_close($curl);

        if (json_decode($response)->status == 200) {
            return true;
        } else {
            return false;
        }
    }

    private function sendToGroup($message)
    {
        $dataSending = array();
        $dataSending["api_key"] = ENV('API_KEY');
        $dataSending["number_key"] = ENV('API_NO_KEY');
        $dataSending["group_id"] = ENV('API_GROUP_ID');
        $dataSending["message"] = $message;
        // $dataSending["wait_until_send"] = "2";
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://api.watzap.id/v1/send_message_group',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => json_encode($dataSending),
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json'
            ),
        ));

        $response = curl_exec($curl);
        curl_close($curl);

        if (json_decode($response)->status == 200) {
            return true;
        } else {
            return false;
        }
    }

    // Ajax
    public function checkAvailability(Request $request)
    {
        try {
            $validated = $request->validate([
                'date' => 'required|date',
                'uuid' => 'required|uuid'
            ]);

            // $date = $validated['date'];
            $date  = Carbon::createFromFormat('d-m-Y', $validated['date'])->format('Y-m-d');
            $uuid = $validated['uuid'];
            $available = [];

            $allItems = MDataBooking::where('tanggal', $date)->where('uuid_ruang', $uuid)->pluck('kode_waktu')->toArray();

            if (in_array('3', $allItems)) {
                $available = [];
            } elseif (in_array('1', $allItems) and in_array('2', $allItems)) {
                $available = [];
            } elseif (in_array('1', $allItems)) {
                $available[] = 2;
            } elseif (in_array('2', $allItems)) {
                $available[] = 1;
            } else {
                $available[] = 1;
                $available[] = 2;
                $available[] = 3;
            }

            return response()->json([
                'success' => true,
                'data' => $available
            ], 200);


            return response()->json([
                'success' => true,
                // 'data' => $available
            ], 200);
        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation Error',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $err) {
            return response()->json([
                'success' => false,
                'message' => 'Something went wrong',
                'error' => $err->getMessage()
            ], 500);
        }
    }
}
