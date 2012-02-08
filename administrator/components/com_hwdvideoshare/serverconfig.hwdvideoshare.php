<?php
class hwd_vs_SConfig{ 

  var $instanceConfig = null;

  // Member variables
  var $ffmpegpath = '/usr/bin/ffmpeg';
  var $flvtool2path = '/usr/bin/flvtool2';
  var $mencoderpath = '/usr/bin/mencoder';
  var $phppath = '/usr/bin/php';
  var $wgetpath = '/usr/bin/wget';
  var $qtfaststart = '/usr/bin/qt-faststart';

  function get_instance(){
    $instanceConfig = new hwd_vs_SConfig;
    return $instanceConfig;
  }

}
?>