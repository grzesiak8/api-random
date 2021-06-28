<?php

namespace RestApi\Operations;

use RestApi\Response;

class Retrive {

    public function __invoke($id)
    {
        $fileToOpen = fopen('storage/' . $id . ".txt", "r");
        $value = fread($fileToOpen, filesize('storage/' . $id . ".txt"));
        fclose($fileToOpen);

        return new Response(
            200,
            [
            'status' => 'OK',
            'id' => $newCount,
            ], 
            true
        );
    }
}