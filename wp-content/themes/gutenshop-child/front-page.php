<?php
get_header(); // fait l'inclusion du fichier header.php

if (have_posts()) : // cette foocntion de WP retourne true s'il y a des elements à afficher 

    // Boucle de WP qui affiche les differents elements : 
    while (have_posts()) : // tant que j'ai des elements a afficher j'entre dans la boucle 
        the_post(); // function de WP qui recupere les données de l'element à afficher et deplace le curseur interne de WP sur l'element suivant a afficher
?>

        <h1 class="col-12">
            <a href="<?php the_permalink(); // affiche le permalien = url de l'element
                        ?>">
                <?php the_title(); // affiche le titre de l'element
                ?>
            </a>
        </h1>

        <div class="col-12">
            <?php the_content(); // affiche tout le contenu papametre dans le BO  
            ?>
        </div>
<?php
    endwhile;

else :
    echo '<p>Aucun contenu à afficher ... </p>';

endif;


// Affichage de la dernière annonce en selectionnant en BDD le dernier post de type "annonce" :

$args = array(
    'post_type' => 'annonce',  // slug du type "annonce"
    'posts_per_page' => 1 // on veut selectionner une annonce (LIMIT 1). Il se ttrouve par defaut un tri par date decroissante(ORDER BY date DESC) : on obtient donc la derniere annonce tout de suite.
);

query_posts($args); // execute la requete de selection




?>


<div class="col-12">
    <hr>
    <h2>Dernière annonce</h2>
    <?php if (have_posts()) : // cette foocntion de WP retourne true s'il y a des elements à afficher 

        // Boucle de WP qui affiche les differents elements : 
        while (have_posts()) : // tant que j'ai des elements a afficher j'entre dans la boucle 
            the_post(); // function de WP qui recupere les données de l'element à afficher et deplace le curseur interne de WP sur l'element suivant a afficher
    ?>

         <div>
             <a href="<?php the_permalink(); ?>">
                <img class="img-fluid w-25" src="<?php the_field('photo');   ?>" alt="dernière annonce publiée">
            </a>
         </div>
         <h3><?php the_title(); ?></h3>
         <h4><?php the_field('prix'); ?>  € TTC</h4>
    <?php
        endwhile;

    else :
        echo '<p>Aucun contenu à afficher ... </p>';

    endif;
    ?>


</div>

<?php
wp_reset_query(); // on n'oublie pas de restaurer la requete principale apres un query_posts();

get_footer(); // fait l'inclusion du fichier footer.php 
?>