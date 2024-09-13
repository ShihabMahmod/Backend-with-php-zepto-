<?php

class Font
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }
    public function uploadFont($fontName, $fontPath, $font_preview)
    {
        try {
            $sql = "INSERT INTO fonts (name, path, preview) VALUES (:name, :path, :preview)";
            $stmt = $this->db->prepare($sql);
            $stmt->execute(['name' => $fontName, 'path' => $fontPath, 'preview' => $font_preview]);
        } catch (PDOException $e) {

            throw new Exception("Error uploading font: " . $e->getMessage());
        }
    }
    public function getAllFonts()
    {
        try {
            $sql = "SELECT * FROM fonts";
            $stmt = $this->db->query($sql);
            
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {

            throw new Exception("Error fetching fonts: " . $e->getMessage());
        }
    }
    public function deleteFont($id)
    {
        try {
            $sql = "DELETE FROM fonts WHERE id = :id";
            $stmt = $this->db->prepare($sql);
            $stmt->execute(['id' => $id]);
        } catch (PDOException $e) {

            throw new Exception("Error deleting font: " . $e->getMessage());
        }
    }
}
