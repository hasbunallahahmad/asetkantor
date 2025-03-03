<?php

namespace App\Notifications;

use App\Models\PembayaranStnk;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PembayaranStnkExpiryNotification extends Notification
{
    use Queueable;
    protected PembayaranStnk $pembayaranStnk;
    protected int $daysRemaining;
    /**
     * Create a new notification instance.
     */


    public function __construct(PembayaranStnk $pembayaranStnk, int $daysRemaining)
    {
        //
        $this->pembayaranStnk = $pembayaranStnk;
        $this->daysRemaining = $daysRemaining;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $kendaraan = $this->pembayaranStnk->kendaraan;
        $jenisPembayaran = $this->pembayaranStnk->jenis_pembayaran;
        return (new MailMessage)
            ->subject("Peringatan: {$jenisPembayaran} untuk kendaraan {$kendaraan->nomor_plat} akan kadaluarsa")
            ->line("Pembayaran {$jenisPembayaran} untuk kendaraan dengan nomor plat {$kendaraan->nomor_plat} akan kadaluarsa dalam {$this->daysRemaining} hari.")
            ->line("Tanggal kadaluarsa: " . $this->pembayaranStnk->berlaku_hingga->format('d M Y'))
            ->action('Lihat Detail', url("/admin/pembayaran-stnks/{$this->pembayaranStnk->id}"))
            ->line('Segera lakukan perpanjangan untuk menghindari denda!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
            'id' => $this->pembayaranStnk->id,
            'jenis_pembayaran' => $this->pembayaranStnk->jenis_pembayaran,
            // 'plat_nomor' => $kendaraan->plat_nomor,
            'berlaku_hingga' => $this->pembayaranStnk->berlaku_hingga->format('d M Y'),
            'days_remaining' => $this->daysRemaining,
        ];
    }
}
