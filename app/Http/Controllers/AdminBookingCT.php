<?php

namespace App\Http\Controllers;

use App\Models\MDataBooking;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class AdminBookingCT extends Controller
{
    public function list(Request $request)
    {
        Carbon::setLocale('id');
        $date = Carbon::now()->format('Y-m-d');

        $pending = MDataBooking::where('status', 'none')->where('tanggal', '>=', $date)->with('ruang')->orderBy('tanggal', 'asc')->get();
        $acc = MDataBooking::where('status', 'accept')->where('tanggal', '>=', $date)->with('ruang')->orderBy('tanggal', 'asc')->get();
        $dec = MDataBooking::where('status', 'decline')->where('tanggal', '>=', $date)->with('ruang')->orderBy('tanggal', 'asc')->get();
        // dd($pending);

        return view('admin.booking.daftar', [
            'title' => 'Booking List | SIRARA',
            'page_title' => 'Daftar Booking',

            'pending' => $pending,
            'accept' => $acc,
            'decline' => $dec
        ]);
    }

    public function detail(Request $request)
    {
        $item = MDataBooking::where('uuid', $request->uuid)->with('ruang')->firstOrFail();

        $waktu = '';
        $waktuMap = [
            '1' => 'Pagi (08:00) - Siang (12:00)',
            '2' => 'Siang (12:00) - Sore (15:00)',
            '3' => 'Pagi (08:00) - Sore (15:00)'
        ];

        $waktu = $waktuMap[$item->kode_waktu] ?? 'Terjadi kesalahan dalam mengurai waktu';
        if ($item) {
            return view('admin.booking.detail', [
                'title' => 'Booking List | SIRARA',
                'page_title' => 'Detail Booking',
                'detail' => $item,
                'waktu' => $waktu

            ]);
        } else {
            return back()->with('error', 'Data tidak ditemukan');
        }
    }

    public function riwayat(Request $request)
    {
        Carbon::setLocale('id');
        $date = Carbon::now()->format('Y-m-d');

        $riwayat = MDataBooking::where('status', 'accept')->where('tanggal', '<=', $date)->with('ruang')->orderBy('tanggal', 'desc')->get();
        return view('admin.booking.riwayat', [
            'title' => 'Riwayat Booking | SIRARA',
            'page_title' => 'Riwayat Booking',
            'riwayat' => $riwayat
        ]);
    }

    public function accept(Request $request)
    {
        try {
            Carbon::setLocale('id');

            $request->validate([
                'uuid' => 'required|string|max:255'
            ]);

            $waktu = '';
            $waktuMap = [
                '1' => 'Pagi (08:00) - Siang (12:00)',
                '2' => 'Siang (12:00) - Sore (15:00)',
                '3' => 'Pagi (08:00) - Sore (15:00)'
            ];

            $item = MDataBooking::where('uuid', $request->uuid)->with('ruang')->firstOrFail();

            // if accept kode_waktu == 3
            if ($item->kode_waktu == '3') {
                $allDecline = MDataBooking::where('tanggal', $item->tanggal)->where('uuid_ruang', $item->uuid_ruang)->where('status', 'none')->where('uuid', '!=', $item->uuid)->with('ruang')->get();
                foreach ($allDecline as $allDecItem) {
                    $waktu = $waktuMap[$allDecItem->kode_waktu] ?? 'Terdapat kesalahan dalam mengurai waktu';
                    $tanggal = Carbon::parse($allDecItem->tanggal)->translatedFormat('d F Y');

                    $declineMessage = "*=== KONFIRMASI PENOLAKAN ===*\n\nMohon maaf permintaan booking Anda:\nKode Booking: " . $allDecItem->kode . "\nNama: " . $allDecItem->nama . "\nWaktu: " . $waktu . "\nTanggal: " . $tanggal . "\n\nAgenda: " . $allDecItem->agenda_rapat . "\nRuang: " . $allDecItem->ruang->ruang . "\nLokasi: " . $allDecItem->ruang->lokasi . "\n\n*Tidak dapat kami penuhi dengan alasan ruangan telah digunakan oleh pihak lain. Silahkan booking di waktu yang berbeda atau di ruangan lain*.\n\n=== TERIMA KASIH ===";

                    $this->sendToNo($allDecItem->no_hp, $declineMessage);
                }
                MDataBooking::where('tanggal', $item->tanggal)->where('uuid_ruang', $item->uuid_ruang)->where('status', 'none')->where('uuid', '!=', $item->uuid)->update(['status' => 'decline']);
            }

            // Tolak waktu dan ruang yang sama
            $autoDecline = MDataBooking::where('tanggal', $item->tanggal)->where('kode_waktu', $item->kode_waktu)->where('uuid_ruang', $item->uuid_ruang)->where('status', 'none')->where('uuid', '!=', $item->uuid)->with('ruang')->get();
            foreach ($autoDecline as $decItem) {
                $waktu = $waktuMap[$decItem->kode_waktu] ?? 'Terdapat kesalahan dalam mengurai waktu';
                $tanggal = Carbon::parse($decItem->tanggal)->translatedFormat('d F Y');

                $declineMessage = "*=== KONFIRMASI PENOLAKAN ===*\n\nMohon maaf permintaan booking Anda:\nKode Booking: " . $decItem->kode . "\nNama: " . $decItem->nama . "\nWaktu: " . $waktu . "\nTanggal: " . $tanggal . "\n\nAgenda: " . $decItem->agenda_rapat . "\nRuang: " . $decItem->ruang->ruang . "\nLokasi: " . $decItem->ruang->lokasi . "\n\n*Tidak dapat kami penuhi dengan alasan ruangan telah digunakan oleh pihak lain. Silahkan booking di waktu yang berbeda atau di ruangan lain*.\n\n=== TERIMA KASIH ===";

                $this->sendToNo($decItem->no_hp, $declineMessage);
            }
            MDataBooking::where('tanggal', $item->tanggal)->where('kode_waktu', $item->kode_waktu)->where('uuid_ruang', $item->uuid_ruang)->where('uuid', '!=', $item->uuid)->where('status', 'none')->update(['status' => 'decline']);


            // Tolak waktu dan ruangan yang bertabrakan
            $additionDecline = MDataBooking::where('tanggal', $item->tanggal)->where('kode_waktu', '3')->where('uuid_ruang', $item->uuid_ruang)->where('status', 'none')->where('uuid', '!=', $item->uuid)->with('ruang')->get();
            foreach ($additionDecline as $additionDecItem) {
                $waktu = $waktuMap[$additionDecItem->kode_waktu] ?? 'Terdapat kesalahan dalam mengurai waktu';
                $tanggal = Carbon::parse($additionDecItem->tanggal)->translatedFormat('d F Y');

                $declineMessage = "*=== KONFIRMASI PENOLAKAN ===*\n\nMohon maaf permintaan booking Anda:\nKode Booking: " . $additionDecItem->kode . "\nNama: " . $additionDecItem->nama . "\nWaktu: " . $waktu . "\nTanggal: " . $tanggal . "\n\nAgenda: " . $additionDecItem->agenda_rapat . "\nRuang: " . $additionDecItem->ruang->ruang . "\nLokasi: " . $additionDecItem->ruang->lokasi . "\n\n*Tidak dapat kami penuhi dengan alasan ruangan telah digunakan oleh pihak lain. Silahkan booking di waktu yang berbeda atau di ruangan lain*.\n\n=== TERIMA KASIH ===";

                $this->sendToNo($additionDecItem->no_hp, $declineMessage);
            }
            MDataBooking::where('tanggal', $item->tanggal)->where('kode_waktu', '3')->where('uuid_ruang', $item->uuid_ruang)->where('status', 'none')->where('uuid', '!=', $item->uuid)->update(['status' => 'decline']);


            // Proses konfirmasi
            $waktu = $waktuMap[$item->kode_waktu] ?? 'Terdapat kesalahan dalam mengurai waktu';
            $tanggal = Carbon::parse($item->tanggal)->translatedFormat('d F Y');

            $message = "*=== KONFIRMASI BOOKING ===*\n\n*Permintaan booking Anda telah dikonfirmasi*. Berikut detail booking Anda:\n\nKode Booking: " . $item->kode . "\nNama: " . $item->nama . "\nWaktu: " . $waktu . "\nTanggal: " . $tanggal . "\n\nAgenda: " . $item->agenda_rapat . "\nRuangan: " . $item->ruang->ruang . "\nLokasi: " . $item->ruang->lokasi . "\n\n_Anda masih dapat melakukan pembatalan hingga batas min 4 jam sebelum waktu yang tertera pada booking._\n\n=== TERIMA KASIH ===";

            $this->sendToNo($item->no_hp, $message);

            $item->status = 'accept';
            $item->save();


            return response()->json([
                'success' => true,
                'message' => 'Permintaan berhasil di konfirmasi'
            ], 200);
        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation Error',
                'errors' => 'Terdapat kesalahan pada parameter UUID'
            ], 422);
        } catch (\Exception $err) {
            return response()->json([
                'success' => false,
                'message' => 'Something went wrong',
                'error' => $err->getMessage()
            ], 500);
        }
    }

    public function decline(Request $request)
    {
        try {
            $request->validate([
                'uuid' => 'required|string|max:100',
                'pesan' => 'nullable|string|max:255'
            ]);

            $item = MDataBooking::where('uuid', $request->uuid)->with('ruang')->firstOrFail();

            $waktu = '';
            $waktuMap = [
                '1' => 'Pagi (08:00) - Siang (12:00)',
                '2' => 'Siang (12:00) - Sore (15:00)',
                '3' => 'Pagi (08:00) - Sore (15:00)'
            ];

            $waktu = $waktuMap[$item->kode_waktu] ?? 'Terdapat kesalahan dalam mengurai waktu';
            $tanggal = Carbon::parse($item->tanggal)->translatedFormat('d F Y');

            $message = "*=== KONFIRMASI PENOLAKAN ===*\n\nMohon maaf permintaan booking Anda:\n\nKode Booking: " . $item->kode . "\nNama: " . $item->nama . "\nWaktu: " . $waktu . "\nTanggal: " . $tanggal . "\n\nAgenda: " . $item->agenda_rapat . "\nRuang: " . $item->ruang->ruang . "\nLokasi: " . $item->ruang->lokasi . "\n\n*Tidak dapat kami penuhi dengan alasan " . $request->pesan . "*.\n\n=== TERIMA KASIH ===";

            $this->sendToNo($item->no_hp, $message);
            $item->status = 'decline';
            $item->save();

            return response()->json([
                'success' => true,
                'message' => $message
            ], 200);
        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation Error',
                'errors' => 'Terdapat kesalahan pada parameter UUID'
            ], 422);
        } catch (\Exception $err) {
            return response()->json([
                'success' => false,
                'message' => 'Something went wrong',
                'error' => $err->getMessage()
            ], 500);
        }
    }

    public function cancel(Request $request)
    {
        try {
            $request->validate([
                'uuid' => 'required|string|max:100',
                'pesan' => 'nullable|string|max:255'
            ]);

            $item = MDataBooking::where('uuid', $request->uuid)->with('ruang')->firstOrFail();

            $waktu = '';
            $waktuMap = [
                '1' => 'Pagi (08:00) - Siang (12:00)',
                '2' => 'Siang (12:00) - Sore (15:00)',
                '3' => 'Pagi (08:00) - Sore (15:00)'
            ];

            $waktu = $waktuMap[$item->kode_waktu] ?? 'Terdapat kesalahan dalam mengurai waktu';
            $tanggal = Carbon::parse($item->tanggal)->translatedFormat('d F Y');

            $message = "*=== KONFIRMASI PEMBATALAN ===*\n\nMohon maaf, booking Anda:\n\nKode Booking: " . $item->kode . "\nNama: " . $item->nama . "\nWaktu: " . $waktu . "\nTanggal: " . $tanggal . "\n\nAgenda: " . $item->agenda_rapat . "\nRuang: " . $item->ruang->ruang . "\nLokasi: " . $item->ruang->lokasi . "\n\n*Kami batalkan dengan alasan " . $request->pesan . "*.\n\n=== TERIMA KASIH ===";

            $this->sendToNo($item->no_hp, $message);
            $item->status = 'decline';
            $item->save();

            return response()->json([
                'success' => true,
                'message' => $message
            ], 200);
        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation Error',
                'errors' => 'Terdapat kesalahan pada parameter UUID'
            ], 422);
        } catch (\Exception $err) {
            return response()->json([
                'success' => false,
                'message' => 'Something went wrong',
                'error' => $err->getMessage()
            ], 500);
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
}
