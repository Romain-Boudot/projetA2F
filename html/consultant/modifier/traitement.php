<?php

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

    } elseif ($_POST['modif'] == "comp") {

        $co = JSON_decode($_POST['comp'], true);

        foreach ($co as $k => $v) {

            if ($v["oldLvl"] == $v["lvl"]) continue;

            if ($v["lvl"] > 3 || $v["lvl"] < 0) continue;

            $c->edit_competence(array(
                "niveau" => $v["lvl"],
                "id_competence" => $v["id"]
            ));

        }

    }