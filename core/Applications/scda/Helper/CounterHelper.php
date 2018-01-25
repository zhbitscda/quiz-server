<?php
/**
 * Created by PhpStorm.
 * User: shanks
 * Date: 16/7/24
 * Time: 上午8:26
 */

class CounterHelper {
    public static function getNewFrameSeq()
    {
        if(isset($_SESSION["sinihi_frame_seq"])) {
            $frame_seq = intval($_SESSION["sinihi_frame_seq"]);
            $frame_seq = $frame_seq + 1;

            $frame_seq = $frame_seq >= 256 ? 1 : $frame_seq;

            $_SESSION["sinihi_frame_seq"] = $frame_seq;
            return $frame_seq;
        }
        $_SESSION["sinihi_frame_seq"] = 1;
        return 1;
    }
}