Copy QrCode Hepler and paste it in your Helper forlder

Copy BarCodeHepler from Vendor and paste it in your Vendor forlder



In which controller you need to use this QR code Helper then use



var $helper = array('QrCode');



Also if you need to use the BarCode then use


App::uses('BarcodeHelper','Vendor');





Also check the barcode function in 


UsersController->barcode function









