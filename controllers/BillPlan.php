<?php 

include_once $_SERVER['DOCUMENT_ROOT'] . '/models/BillPlan.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/controllers/Login.php';

startSession();
checkActivity();

$action = $_POST['action'];

switch($action) {
    case 'getBillPlans':
        getBillPlans();
        break;
    case 'newBillPlan':
        newBillPlan();
        break;
    case 'getBillPlanDetail':
        getBillPlanDetail();
        break;
    case 'updateBillPlan':
        updateBillPlan();
        break;
    case 'deleteBillPlan':
        deleteBillPlan();
        break;
    default:
        break;
}

/** Controlador para guardar un Bill Plan 
 * 
 * @return json - Respuesta con código de éxito o error y su explicación 
 * 
*/
function newBillPlan()
{
    $idQuote = (isset($_POST['idQuote']) ? $_POST['idQuote'] : null);
    $idBillPlan = (isset($_POST['idBillPlan']) ? $_POST['idBillPlan'] : null);
    $downPayment = (isset($_POST['downPayment']) ? $_POST['downPayment'] : null);
    $installments = (isset($_POST['installments']) ? $_POST['installments'] : null);
    $amount = (isset($_POST['amount']) ? $_POST['amount'] : null);
    $idOption = (isset($_POST['idOption']) ? $_POST['idOption'] : null);
    $billPlan = new BillPlan($idBillPlan, $idQuote, $downPayment, $installments, $amount, $idOption);
    $resp = $billPlan->save();
    if ($resp) {
        $resp = array('code' => '200', 'message' => 'Bill Plan saved');
    } else {
        $resp = array('code' => '500', 'message' => 'Error saving Bill Plan');
    }
    echo json_encode($resp);
}

/** Controlador para obtener el detalle de un Bill Plan
 * 
 * @return json - Respuesta con el detalle del Bill Plan
 * 
*/
function getBillPlanDetail()
{
    $id = (isset($_POST['id']) ? $_POST['id'] : null);
    $idQuote = (isset($_POST['idQuote']) ? $_POST['idQuote'] : null);
    $billPlan = new BillPlan();
    $resp = $billPlan->load($id, $idQuote);
    echo json_encode($resp);
}

/** Controlador para listar los Bill Plans de la cotización
 * 
 * @return json - Respuesta con el listado de Bill Plans
 */
function getBillPlans()
{
    $idQuote = (isset($_POST['idQuote']) ? $_POST['idQuote'] : null);
    $billPlan = new BillPlan();
    $resp = $billPlan->listAll($idQuote);
    echo json_encode($resp);
}
