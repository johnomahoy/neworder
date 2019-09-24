<?php
//Test Connection
require_once("isdk.php");	
$app = new iSDK;

if( $app->cfgCon("kf342")){ 

	$websiteUserID = $_REQUEST['websiteUserID'];
	$product1_title = $_REQUEST['product1_title'];
	$product1_ID = $_REQUEST['product1_ID'];
	$product1_Description = $_REQUEST['product1_Description'];
	$product1_Qty = $_REQUEST['product1_Qty'];
	$product1_Notes = $_REQUEST['product1_Notes'];
	$product1_Price = $_REQUEST['product1_Price'];
	
	//
	$DeliveryDate = $_REQUEST['DeliveryDate'];
	$PaymentStatus = $_REQUEST['PaymentStatus'];
	$WebsiteUserID = $_REQUEST['WebsiteUserID']; 
	$PaymentType = $_REQUEST['PaymentType'];
	$DateofPayment = $_REQUEST['DateofPayment'];
	$PaymentAmount = $_REQUEST['PaymentAmount'];
	$TotalOrderValue = $_REQUEST['TotalOrderValue'];
	$WebsiteOrderID = $_REQUEST['WebsiteOrderID'];
	$DateofOrder = $_REQUEST['DateofOrder'];
	
	//Get Data
		$returnFields = array('Id');
		$contacts = $app->dsFind('Contact',1,0,'_websiteUserID',$websiteUserID,$returnFields);
	
	foreach($contacts as $contact=>$key){
		foreach($key as $contactt){ 
			echo $contact_id = $contactt;
		}
	}
	echo "<br>";
	
	//Create Invoice
		$date = $app->infuDate(date('d-m-Y'));
		$invoiceId = $app->blankOrder($contact_id,"New Order", $date, 0, 187);
	 
	foreach($invoiceId as $invoice=>$key){ 
		foreach($key as $invoicee){
			echo $invoice_id = $invoicee;
		}
	} 
	
	$returnFields = array('JobId');
	$contacts = $app->dsFind('Invoice',1,0,'Id',$invoice_id,$returnFields);
	
	foreach($contacts as $contact=>$key){
		foreach($key as $con){
			echo $JobId = $con;
		}
	}
	
	//Search product if exist  
	$counter = 0;
		for($x = 1; $x <= count($product1_ID); $x++){
			$returnFields = array('Id'); 
			$productids = $app->dsFind('Product',1,0,'Id',$product1_ID[$counter],$returnFields);
				
				foreach($productids as $products=>$key){
					foreach($key as $product_ids){
						$productid = $product_ids; 
						
					}
				}
			
				if($product1_ID[$counter] != $productid){
					echo "not equal";
					
					$data = array('ProductName' => $product1_title[$counter]);
						$app->dsAdd("Product", $data); 
						
					$returnFields = array('Id');
					$productid = $app->dsFind('Product',1,0,'ProductName',$product1_title[$counter],$returnFields);
							
					foreach($productid as $prductid=>$key){ 
						foreach($key as $productss){
							echo $temp_product_id = $productss;
						}
					} 
					 
			$result = $app->addOrderItem($invoice_id,$temp_product_id[$counter],4, $product1_Price[$counter], $product1_Qty[$counter], $product1_Description[$counter], $product1_Notes[$counter]);	
			//	
					
					//Add Content to the order custom fields
						$grp = array('_DeliveryDate'  => $DeliveryDate,
						'_PaymentStatus'  => $PaymentStatus,
						'_WebsiteUserID' => $WebsiteUserID,
						'_PaymentType' => $PaymentType,
						'_DateofPayment' => $DateofPayment,
						'_PaymentAmount' => $PaymentAmount,
						'_TotalOrderValue' => $TotalOrderValue,
						'_WebsiteOrderID' => $WebsiteOrderID,
						'_DateofOrder' => $DateofOrder);
						$grpID = $app->dsUpdate("Job",4588,$grp);
						foreach($grpID as $grpd=>$key){
							foreach($key as $id){
								echo $group_id = $id;
							}
						}
					//
				}
				//Condition if product exist
			else{   
				
				$grp = array('ProductName' => $product1_title[$counter]);
				$grpID = $app->dsUpdate("Product", $product1_ID[$counter], $grp);	
			
				 
			//-->Convert from String to Int
			for( $i =0; $i < count( $product1_Qty ); $i++ ){  
			$u[$i] = (string) $product1_Qty[$i];
			}
			
			for( $i =0; $i < count( $u ); $i++ ){  
			$temp_qtyvalue[$i] = (int) $u[$i];
			}
				 
				 
			//-->Convert from String to Int
			for( $i =0; $i < count( $product1_Price ); $i++ ){  
			$c[$i] = (string) $product1_Price[$i];
			}
			
			for( $i =0; $i < count( $c ); $i++ ){  
			$temp_pricevalue[$i] = (float) $c[$i];
			}
			
			
				  
			
			
			$result = $app->addOrderItem($invoice_id,$product1_ID[$counter],4,$temp_pricevalue[$counter],$temp_qtyvalue[$counter],$product1_Description[$counter],$product1_Notes[$counter]);
								
				}
				$counter = $counter + 1;
			}
						//Add Content to the order custom fields
						$grp = array('_DeliveryDate'  => $DeliveryDate,
						'_PaymentStatus'  => $PaymentStatus,
						'_WebsiteUserID' => $WebsiteUserID,
						'_PaymentType' => $PaymentType,
						'_DateofPayment' => $DateofPayment,
						'_PaymentAmount' => $PaymentAmount,
						'_TotalOrderValue' => $TotalOrderValue,
						'_WebsiteOrderID' => $WebsiteOrderID,
						'_DateofOrder' => $DateofOrder);
						$grpID = $app->dsUpdate("Job",$invoice_id,$grp);
						 
						echo $grpID."grpdId"; 
					//
}   
?>