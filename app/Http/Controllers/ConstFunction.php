<?php

function messageRequest($status, $data)
{
    return json_encode(array('status' => $status, 'data' => $data));
}

