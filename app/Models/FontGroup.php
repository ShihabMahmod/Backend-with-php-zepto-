<?php

class FontGroup
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function createGroup($names, $group_name, $font_ids)
    {
 
        $sql = "INSERT INTO font_groups (group_name) VALUES (:group_name)";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['group_name' => $group_name]);
        $groupId = $this->db->lastInsertId();
        
        foreach ($font_ids as $fontId) {
            
            foreach ($font_ids as $index => $fontId) {
                $name = $names[$index] ?? '';
                
                $sql = "INSERT INTO group_ids (name, group_id, font_id) VALUES (:name, :group_id, :font_id)";
                $stmt = $this->db->prepare($sql);
                $stmt->execute([
                    'name' => $name,
                    'group_id' => $groupId,
                    'font_id' => $fontId
                ]);
            }
        }
        return $groupId;
    }

    public function getAllGroups()
    {
        $sql = "SELECT 
                    font_groups.id,
                    font_groups.group_name,
                    GROUP_CONCAT(DISTINCT group_ids.group_id) AS group_ids,
                    GROUP_CONCAT(DISTINCT group_ids.font_id) AS font_ids,
                    GROUP_CONCAT(DISTINCT fonts.name ORDER BY fonts.name SEPARATOR ', ') AS font_names,
                    GROUP_CONCAT(DISTINCT group_ids.name ORDER BY group_ids.name SEPARATOR ', ') AS custom_names
                FROM 
                    font_groups
                INNER JOIN 
                    group_ids ON font_groups.id = group_ids.group_id
                INNER JOIN 
                    fonts ON group_ids.font_id = fonts.id
                GROUP BY 
                    font_groups.id, font_groups.group_name";

        $stmt = $this->db->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getGroupById($id)
    {
        $sql = "SELECT 
    font_groups.id,
    font_groups.group_name,
    GROUP_CONCAT(DISTINCT group_ids.group_id) AS group_ids,
    GROUP_CONCAT(DISTINCT group_ids.font_id) AS font_ids,
    GROUP_CONCAT(DISTINCT fonts.name ORDER BY fonts.name SEPARATOR ', ') AS font_names,
    GROUP_CONCAT(DISTINCT group_ids.name ORDER BY group_ids.name SEPARATOR ', ') AS custom_names
FROM 
    font_groups
INNER JOIN 
    group_ids ON font_groups.id = group_ids.group_id
INNER JOIN 
    fonts ON group_ids.font_id = fonts.id
WHERE 
    font_groups.id = :id
GROUP BY 
    font_groups.id, font_groups.group_name";
;

        $stmt = $this->db->prepare($sql);
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function updateGroup($id, $group_name, $fontIds)
    {
        $sql = "UPDATE font_groups SET group_name = :group_name WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['group_name' => $group_name, 'id' => $id]);
 
        $sql = "DELETE FROM group_ids WHERE group_id = :group_id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['group_id' => $id]);

        foreach ($fontIds as $fontId) {
            $sql = "INSERT INTO group_ids (group_id, font_id) VALUES (:group_id, :font_id)";
            $stmt = $this->db->prepare($sql);
            $stmt->execute(['group_id' => $id, 'font_id' => $fontId]);
        }
    }

    public function deleteGroup($id)
    {
        $sql = "DELETE FROM font_groups WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['id' => $id]);

        $sql = "DELETE FROM group_ids WHERE group_id = :group_id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['group_id' => $id]);
    }
}
