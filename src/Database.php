<?php

class Database
{
    const DATABASE_PATH = __DIR__.'/../base';

    public function offerAlreadyExist($identifier)
    {
        $database = explode("\n", file_get_contents(self::DATABASE_PATH));

        return in_array($identifier, $database);
    }

    public function putOffer($identifier)
    {
        file_put_contents(self::DATABASE_PATH, "$identifier\n", FILE_APPEND);
    }
}