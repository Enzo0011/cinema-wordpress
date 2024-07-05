<?php
/*
Plugin Name: Horaires Cinema Plugin
Description: Un plugin pour créer/modifier/supprimer les horaires des films
Version: 1.0
Author: Enzo GALIEGUE
*/

// Création d'une table quand le plugin est activé
function horaires_cinema_install()
{
    global $wpdb;
    $table_name = $wpdb->prefix . 'horaires_cinema';
    $charset_collate = $wpdb->get_charset_collate();
    $sql = "CREATE TABLE $table_name (
        id mediumint(9) NOT NULL AUTO_INCREMENT,
        film text NOT NULL,
        id_film int NOT NULL,
        horaire text NOT NULL,
        PRIMARY KEY  (id)
    ) $charset_collate;";
    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($sql);
}

// Suppression de la table quand le plugin est désactivé
function horaires_cinema_uninstall()
{
    global $wpdb;
    $table_name = $wpdb->prefix . 'horaires_cinema';
    $sql = "DROP TABLE IF EXISTS $table_name";
    $wpdb->query($sql);
}

// Ajouter un menu dans l'administration
function horaires_cinema_menu()
{
    add_menu_page(
        'Horaires Cinema',
        'Horaires Cinema',
        'manage_options',
        'horaires_cinema',
        'horaires_cinema_page'
    );
}

// Afficher la page d'administration
function horaires_cinema_page()
{
    global $wpdb;
    $table_name = $wpdb->prefix . 'horaires_cinema';
    if (isset($_POST['action']) && $_POST['action'] === 'add') {

        // Vérifie si un film avec le même nom existe déjà
        $film = sanitize_text_field($_POST['film']);
        $result = $wpdb->get_results("SELECT * FROM $table_name WHERE film = '$film'");
        if (count($result) > 0) {
            $id_film = $result[0]->id_film;
        } else {
            // Récupérer l'id max et ajouter 1
            $max_id = $wpdb->get_results("SELECT MAX(id_film) as max_id FROM $table_name")[0]->max_id;
            $id_film = $max_id + 1;
        }

        $film = sanitize_text_field($_POST['film']);
        $horaire = sanitize_text_field($_POST['horaire']);
        $wpdb->insert($table_name, ['film' => $film, 'id_film' => $id_film, 'horaire' => $horaire]);
    }
    if (isset($_POST['action']) && $_POST['action'] === 'delete') {
        $horaire_id = sanitize_text_field($_POST['horaire_id']);
        $result = $wpdb->delete($table_name, ['id' => $horaire_id]);
    }

    $films = $wpdb->get_results("SELECT DISTINCT film, id_film FROM $table_name");
?>
    <!-- prettier-ignore-start -->
    <style>body{font-family:Arial,sans-serif;background-color:#f8f9fa;color:#333;margin:0;padding:20px}h1{color:#4CAF50}table{width:100%;border-collapse:collapse;margin-top:20px;background-color:#fff;box-shadow:0 2px 4px rgba(0,0,0,0.1)}th,td{border:1px solid #ddd;padding:12px;text-align:left}th{background-color:#4CAF50;color:#fff}tr:nth-child(even){background-color:#f2f2f2}tr:hover{background-color:#e9f5e9}form{margin-bottom:10px;display:flex;align-items:center}input[type="text"]{padding:8px;border:1px solid #ccc;border-radius:4px;margin-right:10px;width:calc(100% - 100px)}button{padding:8px 16px;background-color:#4CAF50;color:#fff;border:none;border-radius:4px;cursor:pointer}button:hover{background-color:#45a049}ul{list-style-type:none;padding:0}li{margin-bottom:5px;display:flex;align-items:center}li form{display:flex;align-items:center}li form input[type="text"]{width:auto;margin-right:10px}</style>
    <!-- prettier-ignore-end -->

    <h1>Horaires Cinema</h1>
    <form method="post">
        <input type="hidden" name="action" value="add">
        <label for="film">Film</label>
        <input type="text" name="film" id="film">
        <label for="horaire">Horaire</label>
        <input type="text" name="horaire" id="horaire">
        <button type="submit">Ajouter</button>
    </form>
    <table>
        <thead>
            <tr>
                <th>ID Film</th>
                <th>Film</th>
                <th>Horaire</th>
                <th>Ajouter horaire</th>
            </tr>
        </thead>
        <tbody>
            <?php
            foreach ($films as $film) {
            ?>
                <tr>
                    <td><?php echo $film->id_film; ?></td>
                    <td><?php echo $film->film; ?></td>
                    <td>
                        <ul>
                            <?php
                            $horaires = $wpdb->get_results("SELECT horaire, id FROM $table_name WHERE film = '$film->film'");
                            foreach ($horaires as $horaire) {
                            ?>
                                <li>
                                    <form method="post">
                                        <input type="hidden" name="action" value="edit">
                                        <input type="text" value="<?php echo $horaire->horaire; ?>">
                                        <input type="hidden" name="horaire_id" value="<?php echo $horaire->id; ?>">
                                    </form>
                                    <form method="post">
                                        <input type="hidden" name="action" value="delete">
                                        <input type="hidden" name="horaire_id" value="<?php echo $horaire->id; ?>">
                                        <button type="submit">Supprimer</button>
                                    </form>
                                </li>
                            <?php
                            }
                            ?>
                        </ul>
                    </td>
                    <td>
                        <form method="post">
                            <input type="hidden" name="action" value="add">
                            <input type="hidden" name="film" value="<?php echo $film->film; ?>">
                            <label for="horaire">Horaire</label>
                            <input type="text" name="horaire" id="horaire">
                            <button type="submit">Ajouter</button>
                        </form>
                    </td>
                </tr>
            <?php
            }
            ?>
        </tbody>
    </table>
<?php
}


function horaires_shortcode($atts)
{
    global $wpdb;
    $table_name = $wpdb->prefix . 'horaires_cinema';
    $id_film = $atts['id_film'];
    $horaires = $wpdb->get_results("SELECT horaire FROM $table_name WHERE id_film = '$id_film'");
    $html = "<ul>";
    foreach ($horaires as $horaire) {
        $html .= "<li>$horaire->horaire</li>";
    }
    $html .= "</ul>";
    return $html;
}

register_activation_hook(__FILE__, 'horaires_cinema_install');
register_deactivation_hook(__FILE__, 'horaires_cinema_uninstall');
add_action('admin_menu', 'horaires_cinema_menu');

add_shortcode('horaires', 'horaires_shortcode');
?>
