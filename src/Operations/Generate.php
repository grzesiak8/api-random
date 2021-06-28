<?php

namespace RestApi\Operations;

use RestApi\Response;

class Generate {

    public function __invoke()
    {
        $filesCount  = count(glob("storage/*"));
        $newCount = ($filesCount + 1);

        $newFile = fopen('storage/' . $newCount . ".txt", "w");
        fwrite($newFile, rand(10000,99999));
        fclose($newFile);

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