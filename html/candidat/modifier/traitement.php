<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

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

        exit();

    } elseif ($_POST['modif'] == "int") {

        if (isset($_POST['action'])) if ($_POST['action'] == "add") {

            
            if (isset($_POST['client']) && isset($_POST['date']) && isset($_POST['details'])) {
                
                $c->add_interview(array(
                    "id_rh" => $_POST["rh"],
                    "date" => $_POST["date"],
                    "details" => $_POST["details"]
                ));
                
            }
        
        } elseif ($_POST['action'] == "delete") {

            if (isset($_POST['id'])) {

                $c->delete_interview($_POST['id']);

            }

        }
    }

    header("location: http://" . $_SERVER['HTTP_HOST'] . "/candidat/modifier");
