<?php echo $this->Html->image('barcode/test.png', array('alt' => 'CakePHP'));

echo $this->QrCode->text($mtext); 

die;?>