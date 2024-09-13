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
        $data = json_decode(file_get_contents('php://input'), true);

        if (isset($data['name']) && isset($data['fontIds']) && is_array($data['fontIds'])) {
            $name = $data['name'];
            $fontIds = $data['fontIds'];
            $groupId = $this->fontGroupModel->createGroup($name, $fontIds);
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

    public function getGroup()
    {
        $data = json_decode(file_get_contents('php://input'), true);
        
        if (isset($data['id'])) {
            $groupId = $data['id'];
            $group = $this->fontGroupModel->getGroupById($groupId);
            echo json_encode($group);
        } else {
            echo json_encode(['success' => false, 'message' => 'Invalid ID']);
        }
    }

    public function updateGroup()
    {
        $data = json_decode(file_get_contents('php://input'), true);

        if (isset($data['id']) && isset($data['name']) && isset($data['fontIds']) && is_array($data['fontIds'])) {
            $id = $data['id'];
            $name = $data['name'];
            $fontIds = $data['fontIds'];
            $this->fontGroupModel->updateGroup($id, $name, $fontIds);
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Invalid input']);
        }
    }

    public function deleteGroup()
    {
        //$data = json_decode(file_get_contents('php://input'), true);

        if (isset($data['id'])) {
            $id = $data['id'];
            $this->fontGroupModel->deleteGroup($id);
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Invalid ID']);
        }
    }

    private function jsonResponse($data)
    {
        header('Content-Type: application/json');
        echo json_encode($data);
        exit;
    }
}
