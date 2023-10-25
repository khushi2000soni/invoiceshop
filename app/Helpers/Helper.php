<?php

use App\Models\Order;
use App\Models\Setting;
use App\Models\Uploads;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str as Str;



if (!function_exists('getCommonValidationRuleMsgs')) {
	function getCommonValidationRuleMsgs()
	{
		return [
            'currentpassword.required'=>'The current password is required.',
			'password.required' => 'The new password is required.',
			'password.min' => 'The new password must be at least 8 characters',
			'password.different' => 'The new password and current password must be different.',
			'password.confirmed' => 'The password confirmation does not match.',
			'password_confirmation.required' => 'The new password confirmation is required.',
			'password_confirmation.min' => 'The new password confirmation must be at least 8 characters',
			'email.required' => 'Please enter email address.',
			'email.email' => 'Email is not valid. Enter email address for example test@gmail.com',
            'email.exists' => "Please Enter Valid Registered Email!",
            'password_confirmation.same' => 'The confirm password and new password must match.'
		];
	}
}

if (!function_exists('generateRandomString')) {
	function generateRandomString($length = 20) {

		$randomString = Str::random($length);

		return $randomString;
	}
}

if (!function_exists('uploadImage')) {
	/**
	 * Upload Image.
	 *
	 * @param array $input
	 *
	 * @return array $input
	 */
	function uploadImage($directory, $file, $folder, $type="profile", $fileType="jpg",$actionType="save",$uploadId=null,$orientation=null)
	{
		$oldFile = null;
		if($actionType == "save"){
			$upload               		= new Uploads;
		}else{
			$upload               		= Uploads::find($uploadId);
			$oldFile = $upload->file_path;
		}
		$upload->file_path      	= $file->store($folder, 'public');
		$upload->extension      	= $file->getClientOriginalExtension();
		$upload->original_file_name = $file->getClientOriginalName();
		$upload->type 				= $type;
		$upload->file_type 			= $fileType;
		$upload->orientation 		= $orientation;
		$response             		= $directory->uploads()->save($upload);
		// delete old file
		if($oldFile){
			Storage::disk('public')->delete($oldFile);
		}
		return $upload;
	}
}

if (!function_exists('getSetting')) {
	function getSetting($key)
	{
		$result = null;
		$setting = Setting::where('key',$key)->where('status',1)->first();
		if($setting->type == 'image'){
			$result = $setting->image_url;
		}elseif($setting->type == 'video'){
			$result = $setting->video_url;
		}else{
			$result = $setting->value;
		}
		return $result;
	}
}

if (!function_exists('generateInvoiceNumber')) {
    function generateInvoiceNumber($orderId) {
        $month = now()->format('M'); // Get the current month abbreviation
        $invoiceNumber = strtoupper($month) . '-' . str_pad($orderId, 4, '0', STR_PAD_LEFT);
        return $invoiceNumber;
    }
}

if (!function_exists('generateInvoicePdf')) {
    function generateInvoicePdf($order) {
        $order = Order::with('orderProduct.product')->findOrFail($order);
        $pdfFileName = 'invoice_' . $order->invoice_number . '.pdf';
        $pdf = PDF::loadView('admin.order.pdf.invoice-pdf', compact('order'));
        $pdfContent = $pdf->output();
        // Create a temporary file to save the PDF
        $pdfFileName = 'invoice_' . $order->invoice_number . '.pdf';
        $tempPdfFile = tempnam(sys_get_temp_dir(), 'invoice_');
        file_put_contents($tempPdfFile, $pdfContent);

        return $tempPdfFile;
    }
}

?>
