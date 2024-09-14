<?php

require_once __DIR__ . '/../Models/FontGroup.php';

class FontGroupController
{
    private $fontGroupModel;

    public function __construct($db)
    {
        $this->fontGroupModel = new FontGroup($db);
    }

    public function createGroup()
    {

        if (isset($_POST['name']) && is_array($_POST['font_id'])) {
            $name = $_POST['name'];
            $font_ids = $_POST['font_id'];
            $names = $_POST['names'];
            $groupId = $this->fontGroupModel->createGroup($names,$name, $font_ids);
            echo json_encode(['success' => true, 'groupId' => $groupId]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Invalid input']);
        }
    }

    public function listGroups()
    {
        $groups = $this->fontGroupModel->getAllGroups();
        return $this->jsonResponse($groups);
    }

    public function getGroup($id)
    {
        $group = $this->fontGroupModel->getGroupById($id);
        return $this->jsonResponse($group);
    }

    public function updateGroup($id)
    {

        if (isset($_POST['name']) && is_array($_POST['font_id'])) {
            $name = $_POST['name'];
            $font_ids = $_POST['font_id'];
            $groupId = $this->fontGroupModel->updateGroup($id,$names,$name, $font_ids);
            echo json_encode(['success' => true, 'groupId' => $groupId]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Invalid input']);
        }
    }

    public function deleteGroup($id)
    {
        $data = $this->fontGroupModel->deleteGroup($id);
        $data = array('status'=>'success','message'=> 'Delete successfully');
        return $this->jsonResponse($data);
    }

    private function jsonResponse($data)
    {
        header('Content-Type: application/json');
        echo json_encode($data);
        exit;
    }
}
