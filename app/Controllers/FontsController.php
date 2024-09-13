<?php

class FontGroup
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function createGroup($groupName, $fontIds)
    {
        if (count($fontIds) < 2) {
            throw new Exception('A group must have at least two fonts.');
        }

        $sql = "INSERT INTO font_groups (name) VALUES (:name)";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['name' => $groupName]);

        $groupId = $this->db->lastInsertId();

        foreach ($fontIds as $fontId) {
            $sql = "INSERT INTO font_group_font (group_id, font_id) VALUES (:group_id, :font_id)";
            $stmt = $this->db->prepare($sql);
            $stmt->execute(['group_id' => $groupId, 'font_id' => $fontId]);
        }
    }

    public function getAllGroups()
    {
        $sql = "SELECT * FROM font_groups";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function deleteGroup($id)
    {
        $sql = "DELETE FROM font_groups WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['id' => $id]);
    }
}
