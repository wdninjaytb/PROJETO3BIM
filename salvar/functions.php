<?php

function redimensionarImagem($origem, $larguraMax, $alturaMax, $qualidade = 100) {

    $destino = $origem;
    // Verifica se o arquivo existe
    if (!file_exists($origem)) {
        return false;
    }

    // Pega informações da imagem
    list($larguraOriginal, $alturaOriginal, $tipo) = getimagesize($origem);

    // Calcula proporção
    $proporcao = $larguraOriginal / $alturaOriginal;

    if ($larguraMax / $alturaMax > $proporcao) {
        $novaLargura = $alturaMax * $proporcao;
        $novaAltura = $alturaMax;
    } else {
        $novaLargura = $larguraMax;
        $novaAltura = $larguraMax / $proporcao;
    }

    // Cria nova imagem
    $novaImagem = imagecreatetruecolor($novaLargura, $novaAltura);

    // Cria imagem original conforme tipo
    switch ($tipo) {
        case IMAGETYPE_JPEG:
            $imagem = imagecreatefromjpeg($origem);
            break;
        case IMAGETYPE_PNG:
            $imagem = imagecreatefrompng($origem);

            // Mantém transparência no PNG
            imagealphablending($novaImagem, false);
            imagesavealpha($novaImagem, true);
            break;
        default:
            return false;
    }

    // Redimensiona
    imagecopyresampled(
        $novaImagem,
        $imagem,
        0, 0, 0, 0,
        $novaLargura, $novaAltura,
        $larguraOriginal, $alturaOriginal
    );

    // Salva a imagem
    switch ($tipo) {
        case IMAGETYPE_JPEG:
            imagejpeg($novaImagem, $destino, $qualidade);
            break;
        case IMAGETYPE_PNG:
            imagepng($novaImagem, $destino);
            break;
    }

    // Libera memória
    imagedestroy($imagem);
    imagedestroy($novaImagem);

    return true;
}