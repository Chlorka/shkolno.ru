<?require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
if(!CModule::IncludeModule('yenisite.market') || $_SERVER['REQUEST_METHOD'] != 'POST' || !$_POST['action'])
	return false;
$id_basket_element = IntVal($_POST['id_basket_element']);
$key = str_replace("#", "", htmlspecialchars($_POST['key']));
$return_basket_small = false; 
switch($_POST['action'])
{
	case 'setQuantity':
		$new_quantity = IntVal($_POST['new_quantity']);
			if($new_quantity > 0){
				//if(CSaleBasket::Update($basketItem['ID'], array('QUANTITY' => $new_quantity)))
					//CMarketBasket::Delete($key);
					session_start();
					unset($_SESSION["YEN_MARKET_BASKET"][$key]);					
					CMarketBasket::Add($id_basket_element, array(), $new_quantity );
					echo $new_quantity;					
				//else
					//echo 'err1';
			}
			else{
				//if(CSaleBasket::Delete($basketItem['ID']))
					session_start();
					unset($_SESSION["YEN_MARKET_BASKET"][$key]);	
					echo 'del';
					//$return_basket_small = true;
			}
		
	break;
}?>