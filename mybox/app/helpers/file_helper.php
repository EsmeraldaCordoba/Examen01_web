<?php
    // devuelve el tipo de documento a partir de la extension del archivo
    function tipoDocumento($extension) {
        $extension = strtolower($extension);

        switch ($extension) {
            case 'doc':
            case 'docx':
                return 'Word';
            case 'xls':
            case 'xlsx':
            case 'csv':
                return 'Excel';
            case 'ppt':
            case 'pptx':
                return 'PowerPoint';
            case 'pdf':
                return 'PDF';
            case 'txt':
                return 'Texto';
            case 'jpg':
            case 'jpeg':
            case 'png':
            case 'gif':
            case 'bmp':
            case 'webp':
            case 'svg':
                return 'Imagen';
            case 'zip':
            case 'rar':
            case '7z':
                return 'Comprimido';
            case 'mp3':
            case 'wav':
                return 'Audio';
            case 'mp4':
            case 'avi':
            case 'mkv':
                return 'Video';
            default:
                return 'Otro (' . $extension . ')';
        }
    }