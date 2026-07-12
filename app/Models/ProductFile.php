<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductFile extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'product_id',
        'file_name',
        'original_name',
        'file_path',
        'file_url',
        'file_size',
        'mime_type',
        'file_hash',
        'file_type',
        'is_protected',
        'is_active',
        'is_public',
        'download_limit',
        'download_count',
        'last_downloaded_at',
        'width',
        'height',
        'duration_seconds',
        'file_metadata'
    ];

    protected $casts = [
        'file_size' => 'integer',
        'download_limit' => 'integer',
        'download_count' => 'integer',
        'width' => 'integer',
        'height' => 'integer',
        'duration_seconds' => 'integer',
        'file_metadata' => 'array',
        'is_protected' => 'boolean',
        'is_active' => 'boolean',
        'is_public' => 'boolean',
        'last_downloaded_at' => 'datetime',
    ];

    // ==================== RELATIONSHIPS ====================
    
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    // ==================== HELPERS ====================
    
    public function getFileSizeHuman(): string
    {
        if (!$this->file_size) {
            return '0 B';
        }

        $bytes = (int) $this->file_size;
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];
        
        for ($i = 0; $bytes > 1024; $i++) {
            $bytes /= 1024;
        }
        
        return round($bytes, 2) . ' ' . $units[$i];
    }

    public function getFileExtension(): string
    {
        return pathinfo($this->original_name, PATHINFO_EXTENSION);
    }

    public function getDownloadUrl(): string
    {
        if (config('filesystems.default') === 's3') {
            return Storage::temporaryUrl(
                $this->file_path,
                now()->addMinutes(10),
                ['ResponseContentDisposition' => 'attachment; filename="' . $this->original_name . '"']
            );
        }
        
        return route('product.file.download', ['id' => $this->id, 'token' => $this->generateToken()]);
    }

    public function canDownload(): bool
    {
        if (!$this->is_active) {
            return false;
        }
        
        if ($this->download_limit === null || $this->download_limit === 0) {
            return true;
        }
        
        return $this->download_count < $this->download_limit;
    }

    public function incrementDownload(): void
    {
        $this->increment('download_count');
        $this->last_downloaded_at = now();
        $this->save();
    }

    public function generateToken(): string
    {
        return hash_hmac('sha256', $this->id . $this->file_hash, config('app.key'));
    }

    public function verifyToken(string $token): bool
    {
        return $this->generateToken() === $token;
    }

    public function getFileTypeLabel(): string
    {
        $labels = [
            'main' => 'Main File',
            'preview' => 'Preview',
            'sample' => 'Sample',
            'source' => 'Source Code',
            'documentation' => 'Documentation',
            'update' => 'Update',
            'thumbnail' => 'Thumbnail',
            'screenshot' => 'Screenshot'
        ];

        return $labels[$this->file_type] ?? $this->file_type;
    }

    public function getIcon(): string
    {
        $extension = $this->getFileExtension();
        
        $icons = [
            'pdf' => 'fe-file-text',
            'doc' => 'fe-file-text',
            'docx' => 'fe-file-text',
            'xls' => 'fe-file-text',
            'xlsx' => 'fe-file-text',
            'ppt' => 'fe-file-text',
            'pptx' => 'fe-file-text',
            'txt' => 'fe-file-text',
            'zip' => 'fe-archive',
            'rar' => 'fe-archive',
            '7z' => 'fe-archive',
            'png' => 'fe-image',
            'jpg' => 'fe-image',
            'jpeg' => 'fe-image',
            'gif' => 'fe-image',
            'svg' => 'fe-image',
            'webp' => 'fe-image',
            'mp4' => 'fe-video',
            'mov' => 'fe-video',
            'avi' => 'fe-video',
            'mkv' => 'fe-video',
            'mp3' => 'fe-music',
            'wav' => 'fe-music',
            'aac' => 'fe-music',
            'flac' => 'fe-music',
            'exe' => 'fe-cpu',
            'msi' => 'fe-cpu',
            'dmg' => 'fe-cpu',
            'apk' => 'fe-smartphone',
            'ipa' => 'fe-smartphone',
        ];

        return $icons[$extension] ?? 'fe-file';
    }

    public function getColor(): string
    {
        $extensions = [
            'pdf' => 'danger',
            'doc' => 'primary',
            'docx' => 'primary',
            'xls' => 'success',
            'xlsx' => 'success',
            'ppt' => 'warning',
            'pptx' => 'warning',
            'zip' => 'secondary',
            'rar' => 'secondary',
            '7z' => 'secondary',
            'png' => 'info',
            'jpg' => 'info',
            'jpeg' => 'info',
            'gif' => 'info',
            'svg' => 'info',
            'mp4' => 'dark',
            'mov' => 'dark',
            'mp3' => 'danger',
            'wav' => 'danger',
        ];

        return $extensions[$this->getFileExtension()] ?? 'secondary';
    }
}