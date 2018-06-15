<?php

    Security::check_login(array(0, 1, 2));

    if ($_POST['modif'] == "info") {

        if (isset($_POST['nom'])) {
            if ($c->get_nom() != $_POST["nom"]) {
                $c->set_nom($_POST['nom']);
            }
        }

        if (isset($_POST['prenom'])) {
            if ($c->get_prenom() != $_POST["prenom"]) {
                $c->set_prenom($_POST['prenom']);
            }
        }

        if (isset($_POST['email'])) {
            if ($c->get_email() != $_POST["email"]) {
                $c->set_email($_POST['email']);
            }
        }

        if (isset($_POST['telephone'])) {
            if ($c->get_telephone() != $_POST["telephone"]) {
                $c->set_telephone($_POST['telephone']);
            }
        }

        if (isset($_POST['linkedin'])) {
            if ($c->get_linkedin() != $_POST["linkedin"]) {
                $c->set_linkedin($_POST['linkedin']);
            }
        }

        $c->send_modif();


    } elseif ($_POST['modif'] == "comp") {

        $co = JSON_decode(urldecode($_POST['comp']), true);

        foreach ($co as $k => $v) {

            if ($v["oldLvl"] == $v["lvl"]) continue;

            if ($v["lvl"] > 3 || $v["lvl"] < 0) continue;

            $c->edit_competence(array(
                "niveau" => $v["lvl"],
                "id_competence" => $v["id"]
            ));

        }

    } elseif ($_POST['modif'] == "int") {

        if (isset($_POST['action'])) if ($_POST['action'] == "add") {

            
            if (isset($_POST['RH']) && isset($_POST['date']) && isset($_POST['details'])) {
                
                $c->add_interview(array(
                    "id_rh" => $_POST["RH"],
                    "date_entretien" => $_POST["date"],
                    "details" => $_POST["details"]
                ));
                
            }
        
        } elseif ($_POST['action'] == "delete") {

            if (isset($_POST['id'])) {

                $c->delete_interview($_POST['id']);

            }

        }

    } elseif ($_POST['modif'] == "qual") {

        if (isset($_POST['action'])) if ($_POST['action'] == "add") {

            if (isset($_POST['nom']) && isset($_POST['date']) && isset($_POST['details'])) {
                
                $c->add_qualification(array(
                    "nom_qualification" => $_POST["nom"],
                    "date_obtention" => $_POST["date"],
                    "details" => $_POST["details"]
                ));
                
            }

        } elseif ($_POST['action'] == "delete") {
            
            if (isset($_POST['id'])) {

                $c->delete_qualification($_POST['id']);

            }

        }

    }
$id = $c->get_id();


header("location: http://" . $_SERVER['HTTP_HOST'] . "/candidat/modifier/?id=" . $id ."");
//header("location: http://" . $_SERVER['HTTP_HOST'] . "/");
