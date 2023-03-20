<?php
/*
Plugin Name: Stratis
Description: Ce plugin ajoute un shortcode avec un formulaire pour créer un nouveau message non publié et envoyer un e-mail à l'administrateur.
Version: 1.0
Author: Donia Ben Belgacem
*/

// Définition du shortcode
add_shortcode( 'stratis_post_formulaire', 'stratis_post_formulaire_shortcode' );

function stratis_post_formulaire_shortcode() {
    // Traitement du formulaire soumis
    if ( isset( $_POST['stratis_post_formulaire_submit'] ) ) {
    // Récupération des données soumises
    $titre = sanitize_text_field( $_POST['stratis_post_formulaire_titre'] );
    $texte = sanitize_text_field( $_POST['stratis_post_formulaire_texte'] );

            // Validation du champ titre
            if ( get_page_by_title( $titre , OBJECT, 'post') != null )  {
                $erreur = 'Un article avec le meme titre existe deja.';
            } else {
            // Création d'un nouveau message non publié
            $nouveau_message = array(
                'post_title'   => $titre,
                'post_content' => $texte,
                'post_status'  => 'draft',
                'post_type'    => 'post'
            );
            $message_id = wp_insert_post( $nouveau_message );

            // Envoi d'un e-mail à l'administrateur
            $to = get_option( 'admin_email' );
            $subject = 'Nouveau message crée';
            $message = 'Un nouveau message a été crée avec le titre : ' . $titre . ' et le texte : ' . $texte;
            wp_mail( $to, $subject, $message );
            // Affichage d'un message de confirmation
            $confirmation = 'Le nouveau message a ete crée avec succes.';
        }
    }

    // Affichage du formulaire
    $output = '<form class="formulaire-post" method="post" action="' . esc_url( $_SERVER['REQUEST_URI'] ) . '">';
    $output .=' <div class="form-item">';
    $output .= '<p class="formLabel" for="stratis_post_formulaire_titre">Titre :</p>';
    $output .= '<input class="form-style" type="text" id="stratis_post_formulaire_titre" name="stratis_post_formulaire_titre" required><br>';
    $output .=' </div>';
    $output .=' <div class="form-item">';
    $output .= '<p class="formLabel" for="stratis_post_formulaire_texte">Texte :</p>';
    $output .= '<input class="form-style" type="text" id="stratis_post_formulaire_texte" name="stratis_post_formulaire_texte" required></input><br>';
    $output .=' </div>';
    $output .= '<input type="submit" id="submit-btn" name="stratis_post_formulaire_submit" value="Creer le message">';
    $output .= '</form>';

    // Affichage des messages d'erreur ou de confirmation
    if ( isset( $erreur ) ) {
        $output .= '<div class="stratis_post_formulaire_erreur">' . $erreur . '</div>';
    }
    if ( isset( $confirmation ) ) {
        $output .= '<div class="stratis_post_formulaire_confirmation">' . $confirmation . '</div>';
    }

    return $output;
}

function stratis_enqueue_scripts() {
     // Register jQuery
     wp_register_script( 'jquery', 'https://code.jquery.com/jquery-3.6.0.min.js', array(), '3.6.0', true );
  
    // Enqueue the custom CSS file
    wp_enqueue_style( 'stratis-custom-css', plugins_url( 'views/css/custom.css', __FILE__ ) );
    
   
    // Enqueue the custom JS file
    wp_enqueue_script( 'stratis-custom-js', plugins_url( 'views/js/custom.js', __FILE__ ), array( 'jquery' ), '1.0', true );
    wp_enqueue_script('jquery');
}
add_action( 'wp_enqueue_scripts', 'stratis_enqueue_scripts' );

