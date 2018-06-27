<?php

    if (!$pass) exit();

    if ($_POST['modif'] == "info") {

        if (isset($_POST['nom'])) {
            if ($c->get_nom() != $_POST["nom"]) {
                $c->set_nom($_POST['nom']);
            }
        }

        if (isset($_POST['login'])) {
            if ($c->get_login() != $_POST["login"]) {
                $c->set_login($_POST['login']);
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

            if (isset($_POST['date']) && isset($_POST['details']) && isset($_POST['entreprise'])) {

                if ((strlen($_POST['client'])) > 0) {
        
                    $client = Client::check_exist($_POST['client']);

                    var_dump($client);

                    $id_client = $client['id_client'];



                    if ($client == false){

                        Client::add_client($_POST['client']);

                    }     

                } else { 
                    $id_client = NULL;
                }

                $entreprise = Entreprise::check_exist($_POST['entreprise']);
    
                if ($entreprise == false) {

                    Entreprise::add_entreprise($_POST['entreprise']);
                    
                }
                $c->add_intervention(array(
                    "id_client" => $id_client,
                    "date" => $_POST["date"],
                    "date_fin" => $_POST["date_fin"],
                    "id_entreprise" => $entreprise['id_entreprise'],
                    "details" => $_POST["details"]
                ));
            }
        
        } elseif ($_POST['action'] == "delete") {

            if (isset($_POST['id'])) {

                $c->delete_intervention($_POST['id']);

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

    } elseif ($_POST['modif'] == "graph") {
        
        if (isset($_POST['graph1'])) {

            $g = JSON_decode(urldecode($_POST['graph1']), true);

            $c->delete_graphique(1);

            foreach ($g as $k => $v) {
                
                $c->add_graphique(1, $k);

            }

        }

        if (isset($_POST['graph2'])) {

            $g = JSON_decode(urldecode($_POST['graph2']), true);

            $c->delete_graphique(2);

            foreach ($g as $k => $v) {
                
                $c->add_graphique(2, $k);

            }

        }

        if (isset($_POST['graph3'])) {

            $g = JSON_decode(urldecode($_POST['graph3']), true);

            $c->delete_graphique(3);

            foreach ($g as $k => $v) {
                
                $c->add_graphique(3, $k);

            }

        }

    }

//    header("location: http://" . $_SERVER['HTTP_HOST'] . "/consultant/modifier/");
