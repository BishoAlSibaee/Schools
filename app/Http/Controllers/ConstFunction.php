<?php

function messageRequest($code,$status, $data)
{
    //code (1,0,-1) 1 => success , 0 => no records , -1 => failed or error 
    return json_encode(array('code'=>$code,'status' => $status, 'data' => $data));
}

