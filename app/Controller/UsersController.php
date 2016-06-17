<?php

/**
 * Users controller.
 *
 * This file will render views from views/pages/
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright 2005-2012, Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2005-2012, Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Controller
 * @since         CakePHP(tm) v 0.2.9
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
App::uses('AppController', 'Controller');
App::uses('CakeNumber', 'Utility');

/**
 * Users controller
 *
 * Override this controller by placing a copy in controllers directory of an application
 *
 * @package       app.Controller
 * @link http://book.cakephp.org/2.0/en/controllers/pages-controller.html
 */
class UsersController extends AppController {

    /**
     * Controller name
     *
     * @var string
     */
    public $name = 'Users';

    /**
     * This controller does not use a model
     *
     * @var array
     */
    public $uses = array();
    var $helper = array('QrCode');
    var $components = array();

    /**
     * Displays a view
     *
     * @param mixed What page to display
     * @return void
     */
    function beforeFilter() {

        $this->Auth->allow(array('barcode'));
        parent::beforeFilter();
    }
    
    function barcode(){
        App::uses('BarcodeHelper','Vendor');
        $data_to_encode = 'Nameofcompany : KIPL';
   
        $barcode=new BarcodeHelper();

        // Generate Barcode data
        $barcode->barcode();
        $barcode->setType('C128');
        $barcode->setCode($data_to_encode);
        $barcode->setSize(80,200);

        // Generate filename           
        $random = rand(0,1000000);
        $file = 'img/barcode/code.png';
    
        // Generates image file on server           
        $barcode->writeBarcodeFile($file);
        //die;
        // making the image transparent Start //
        $picture = imagecreatefrompng(WWW_ROOT.$file);
        $img_w = imagesx($picture);
        $img_h = imagesy($picture);

        $newPicture = imagecreatetruecolor( $img_w, $img_h );
        imagesavealpha( $newPicture, true );
        $rgb = imagecolorallocatealpha( $newPicture, 0, 0, 0, 127 );
        imagefill( $newPicture, 0, 0, $rgb );
        $color = imagecolorat( $picture, $img_w-1, 1);

        for( $x = 0; $x < $img_w; $x++ ) {
           for( $y = 0; $y < $img_h; $y++ ) {
               $c = imagecolorat( $picture, $x, $y );
               if($color!=$c){      
                   imagesetpixel( $newPicture, $x, $y,    $c);          
               }        
           }
        }

        imagepng($newPicture, WWW_ROOT.'img\barcode\test.png');
        imagedestroy($newPicture);
        imagedestroy($picture);
        // END
        $this->set('mtext',$data_to_encode);

    }
}
