<?php

    /**
     * Checks if all uploads are good and have the correct extension
     *
     * @param array $files Uploaded files
     * @param array $extensions Possible extensions
     * @return bool if they do
     */
    function uploadOK(array $files, $extensions) {
        foreach ($files as $file) {
            if (($file['error'] !== UPLOAD_ERR_OK) || !extensionMatches($file['name'], $extensions)) return false;
        }
        return true;
    }

    /**
     * Checks if the uploaded file has the correct extension
     *
     * @param string $file Filename
     * @param array $extensions Possible extensions
     * @return bool if it does
     */
    function extensionMatches(string $file, array $extensions) {
        $p = pathinfo($file);
        foreach ($extensions as $e) {
            if ($p['extension'] === $e) return true;
        }
        return false;
    }

    /**
     * Parses uploaded files
     *
     * @param string $type Filter per type
     * @return array files
     */
    function checkUploadedFile(string $type="img") {

        if (sizeof($_FILES) === 0) return array();

        $available = [
            'img' => array(
                'png',
                'jpg',
                'jpeg',
                'gif',
                'tif',
                'tiff'
            ),
            'doc' => array(
                'pdf',
                'odt',
                'doc',
                'docx'
            ),
            'vid' => array(
                'mp3',
                'gif',
                'webm',
                'wmv'
            )
        ];

        $used = [];
        if (in_array($type, $available)) {
            $used = $available[$type];
        } else if ($type === "any") {
            foreach ($available as $i => $a) {
                $used = array_merge($used, $a);
            }
        }

        return (sizeof($used) > 0 && uploadOK($_FILES, $used));
    }

    /**
     * Moves all $_FILES to uploads
     *
     * @return array paths
     */
    function saveUploadedFiles() {
        $r = [];
        foreach ($_FILES as $file) {
            $t = get_path("database", "uploads/") . uniqid() . pathinfo($file['name']['extension']);
            move_uploaded_file($file['tmp_name'], $t);
            array_push($r, $t);
        }
        return $r;
    }
?>