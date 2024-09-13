<?php

require_once __DIR__ . '/../Models/Font.php';

class FontController
{
    private $fontModel;

    public function __construct($db)
    {
        $this->fontModel = new Font($db);
    }
    public function uploadFont()
    {

        if (isset($_FILES['font'])) {
            $fileType = pathinfo($_FILES['font']['name'], PATHINFO_EXTENSION);
            

            if (strtolower($fileType) === 'ttf') {
                $targetDir = '../public/uploads/';
                $fontName = basename($_FILES["font"]["name"]);
                $targetFilePath = $targetDir . $fontName;
                $preview = isset($_POST['preview']) ? $_POST['preview'] : '';

                if (move_uploaded_file($_FILES["font"]["tmp_name"], $targetFilePath)) {
                    $this->fontModel->uploadFont($fontName, $targetFilePath, $preview);
                    echo json_encode(['success' => true]);
                } else {
                    echo json_encode(['success' => false, 'message' => 'File upload failed.']);
                }
            } else {
                echo json_encode(['success' => false, 'message' => 'Invalid file type. Only TTF files are allowed.']);
            }
        } else {
            echo json_encode(['success' => false, 'message' => 'No file uploaded.']);
        }
    }
    public function delete($id)
    {
        $data = $this->fontModel->deleteFont($id);
        $data = array('status'=>'success','message'=> 'Delete successfully');
        return $this->jsonResponse($data);
    }
    public function listFonts()
    {
        $fonts = $this->fontModel->getAllFonts();
        return $this->jsonResponse($fonts);
    }
    private function jsonResponse($data)
    {
        header('Content-Type: application/json');
        echo json_encode($data);
        exit;
    }
}
