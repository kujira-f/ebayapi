<?php
	function ebayapi_get1($x){
		//$savePath = 'C:\ebayapi\data\'; //�C�ӂ̏ꏊ
		print "\n";
		$xml = '<?xml version="1.0" encoding="utf-8"?><GetMyeBayBuyingRequest xmlns="urn:ebay:apis:eBLBaseComponents"><RequesterCredentials><eBayAuthToken>AgAAAA**AQAAAA**aAAAAA**cnHfVw**nY+sHZ2PrBmdj6wVnY+sEZ2PrA2dj6wBk4OkDpOBpgidj6x9nY+seQ**6W8DAA**AAMAAA**4eY4EL83y5MhVispZqS0mN4I5ll4AxRcH+bEgNb+A4e2DNtnNWgeJ/h6pTwRJpEo3uye5hRXcjWvCWjcMu/qQ2A+st5FaYFVof7QQmzHG/XbvDRT2dAZBQY7g78xCEZDwwGDI2cHjKtnOh08+2ZP+m5TPJVFCQA4u+Qikt24bXoEK4TKWfF+RqbeE+7EAX9NjnSGOW0k8FmXU8yY19kG56aH4qDqJW1hgEFg220bNXAqOG6UKEqAi60AiHkgLe6QxCdhvBp57HG71VJgaEhhK/VCitNiXtJvO2csrl3jZMW7sdSEMge28daJcyC2P1tTRvhDeiJo+HQJ/VZKJHocFPdksIjvHm9pBsoDLQldbPqqtOhGFFagBkZM5m2SEERz8Tnu+i3PdQs82P/9iJcsxujutfDBonZS68GQtgBFgDXC0qls+VcmuE3122SZqsA5dwjhNbzVnpPAzMrtLdpG4ejLqA1jbBBcy3q2MJbmOGrU4cx+BPq39PgMzsrV7xJDWw/Id2M3pCspQI6Gl7hdJO0JOrRKBnkmTfPO/oXR9UlFjUw8rcdZta60D4QL9/u/p0NdQTkXjbGQvkM6XJDwL2w733EHqqhaZHaMib6dsXmrYd4WW0vuLNkZWeAZau2rZ9ys+gQSv85Xyzb8G/oaIl1vDAwr7lvZtYDaEcR8HrPpo9AKKUtvxwfYysoizp5yRw3vbACF1veAqVO/QjZh8ZoSbLYDGVqzxgwS3a/SWr/cSTjh1Do31cAkvfMs9tmE</eBayAuthToken></RequesterCredentials><DetailLevel>ReturnAll</DetailLevel><BuyingSummary><Include>true</Include></BuyingSummary></GetMyeBayBuyingRequest>';
		//POST�f�[�^���i�[
		//$data = array(
		//    "data" => $xml
		//);
		//$data = http_build_query($data, "", "&");

		//�w�b�_�[�f�[�^������
		$header = array(
		    "X-EBAY-API-COMPATIBILITY-LEVEL : 793",
		    "X-EBAY-API-APP-NAME : xxxxxxxxxxxxxxxxxx",
		    "X-EBAY-API-CERT-NAME  : xxxxxxxxxxxxxxxxxxxxx",
		    "X-EBAY-API-DEV-NAME  : xxxxxxxxxxxxxxxxxxxx",
		    "X-EBAY-API-SITEID  : 0",
		    "X-EBAY-API-CALL-NAME  : GetMyeBayBuying",
		    "X-EBAY-API-DETAIL-LEVEL: 0",
		    "Content-Type: text/xml;charset=UTF-8"
		);

		//�X�g���[���R���e�L�X�g�N���G�C�g
		$contextOptions = array(
		    'http' => array(
		        "method"  => "POST",
		        "header"  => implode("\r\n", $header),
		        "content" => $xml
		    )
		);
		$sslContext = stream_context_create($contextOptions);

		$url = "https://api.ebay.com/ws/api.dll";

		//�����I
		$ret = file_get_contents($url, false, $sslContext);

		$array = json_decode(json_encode(simplexml_load_string($ret)), true);
		$WonList = $array["WonList"] ;
		$OrderTransactionArray = $WonList["OrderTransactionArray"] ;
		$OrderTransaction = $OrderTransactionArray["OrderTransaction"] ;
		//�f�o�b�O�p
        //var_dump($OrderTransaction);
        foreach ($OrderTransaction as $value) {
        	//1����
        	print "ItemID:";
		    print $value["Transaction"]["Item"]["ItemID"];
		    print " UserID:\:";
		    print $value["Transaction"]["Item"]["Seller"]["UserID"];
		    print " CreatedDate:\:";
		    print $value["Transaction"]["CreatedDate"];
		    print " GalleryURL:\:";
		    print $value["Transaction"]["Item"]["PictureDetails"]["GalleryURL"];
		    print " Title:\:";
		    print $value["Transaction"]["Item"]["Title"];
        	print " QuantityPurchased:\:";
		    print $value["Transaction"]["QuantityPurchased"];
        	print " TotalTransactionPrice:\:";
		    print $value["Transaction"]["TotalTransactionPrice"];
        	print " ShippingServiceCost:\:";
		    print $value["Transaction"]["Item"]["ShippingDetails"]["ShippingServiceOptions"]["ShippingServiceCost"];
		    print " BuyerPaidStatus:\:";
		    print $value["Transaction"]["BuyerPaidStatus"];
        	print " TotalPrice:\:";
		    print $value["Transaction"]["TotalPrice"];
		    if (strpos($value["Transaction"]["Item"]["PictureDetails"]["GalleryURL"],".jpg")){
		    	$targetImgUrl = $value["Transaction"]["Item"]["PictureDetails"]["GalleryURL"];
		    	$fileNameTmp = explode( '/', $targetImgUrl );
		    	$fileNameTmp = array_reverse( $fileNameTmp );
                $fileName = $fileNameTmp[ 0 ];
                //@file_put_contents( self::IMG_SAVE_PATH . $fileName, $imgData );
                $imgData = @file_get_contents( $targetImgUrl );
                if ( $imgData )
                {
                    @file_put_contents( "c:/ebayapi/data/" . $fileName, $imgData );
                }
		    }

		    //��������
		    for($a = 0; $a < 20; $a++)
		   {
	        	print "ItemID:";
			    print $value["Order"]["TransactionArray"]["Transaction"][$a]["Item"]["ItemID"];
			    print " UserID:\:";
			    print $value["Order"]["TransactionArray"]["Transaction"][$a]["Item"]["Seller"]["UserID"];
			    print " CreatedDate:\:";
			    print $value["Order"]["TransactionArray"]["Transaction"][$a]["CreatedDate"];
			    print " GalleryURL:\:";
			    print $value["Order"]["TransactionArray"]["Transaction"][$a]["Item"]["PictureDetails"]["GalleryURL"];
			    print " Title:\:";
			    print $value["Order"]["TransactionArray"]["Transaction"][$a]["Item"]["Title"];
	        	print " QuantityPurchased:\:";
			    print $value["Order"]["TransactionArray"]["Transaction"][$a]["QuantityPurchased"];
	        	print " TotalTransactionPrice:\:";
			    print $value["Order"]["TransactionArray"]["Transaction"][$a]["TotalTransactionPrice"];
	        	print " ShippingServiceCost:\:";
			    print $value["Order"]["TransactionArray"]["Transaction"][$a]["Item"]["ShippingDetails"]["ShippingServiceOptions"]["ShippingServiceCost"];
			    print " BuyerPaidStatus:\:";
			    print $value["Order"]["TransactionArray"]["Transaction"][$a]["BuyerPaidStatus"];
	        	print " TotalPrice:\:";
			    print $value["Order"]["Total"];
			    if (strpos($value["Order"]["TransactionArray"]["Transaction"][$a]["Item"]["PictureDetails"]["GalleryURL"],".jpg")){
			    	$targetImgUrl = $value["Order"]["TransactionArray"]["Transaction"][$a]["Item"]["PictureDetails"]["GalleryURL"];
			    	$fileNameTmp = explode( '/', $targetImgUrl );
			    	$fileNameTmp = array_reverse( $fileNameTmp );
	                $fileName = $fileNameTmp[ 0 ];
	                //@file_put_contents( self::IMG_SAVE_PATH . $fileName, $imgData );
	                $imgData = @file_get_contents( $targetImgUrl );
	                if ( $imgData )
	                {
	                    @file_put_contents( "c:/ebayapi/data/" . $fileName, $imgData );
	                }
			    }
			    print "\n";
		    }
		    print "\n";
		}

  }
?>
