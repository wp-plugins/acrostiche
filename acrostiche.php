<?php
/*
Plugin Name: Acrostiche
Plugin URI: http://martouf.ch/document/88-liste-de-qualites.html
Description: Un plugin qui fait des acrostiches en français. A partir d'un prénom il donne une liste de qualités. This plugin generate an acrostic in french based on a first name
Author: Mathieu Despont
Version: 1
Author URI: http://ecodev.ch
*/
/*  Copyright 2011  Mathieu Despont  (email : mathieu@martouf.ch)

	This program is free software; you can redistribute it and/or modify
	it under the terms of the GNU General Public License as published by
	the Free Software Foundation; either version 2 of the License, or
	(at your option) any later version.

	This program is distributed in the hope that it will be useful,
	but WITHOUT ANY WARRANTY; without even the implied warranty of
	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
	GNU General Public License for more details.

	You should have received a copy of the GNU General Public License
	along with this program; if not, write to the Free Software
	Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/
/* ==================================================================================
 * Ce plugin génère un acrostiche pour un prénom donné avec des qualités.
 * This plugin generate an acrostic in french based on a first name
 * ================================================================================== */

// version 1: 2011-04-04

global $action;

$action = 'getForm';
if (isset($_GET['getAcrostiche'])) {
	$action = 'getAcrostiche';
}

// récupère le texte à transformer en acrostiche
$texte = '';
if (isset($_POST['texte'])) {
	$texte = $_POST['texte'];
}

// affiche le code html en brut dans la page pour qu'il soit récupéré par le javascript lors de l'appel ajax
if ($action=='getAcrostiche') {
	if (!empty($texte)) {
		echo displayAcrostiche($texte);
		exit(0);
	}
}

// ajout du formulaire via un shortcode [acrosticheForm] dans la page
add_shortcode('acrosticheForm','displayAcrosticheForm');

// ajoute l'importation du css dans le header
add_action('wp_head', 'acrosticheCss');

function acrosticheCss(){
	echo '<link rel="stylesheet" href="/wp-content/plugins/acrostiche/acrostiche.css" media="all" type="text/css" />';
}

function displayAcrostiche($txt){
	// génère le code html à afficher
	$htmlAcrostiche = "<ul id=\"listeAcrostiche\" >";
	$acrostiche = text2acrostic($txt);
	foreach ($acrostiche as $key => $quality) {
		$htmlAcrostiche .= "<li class=\"firstLetter\">";
		$htmlAcrostiche .= stripcslashes(ucfirst($quality));
		$htmlAcrostiche .= "</li>";
	}
	$htmlAcrostiche .= "</ul>";
	
	return $htmlAcrostiche;
}


// fonction de création de l'acrostiche.
// @return array la liste de qualité
function text2acrostic($text){

	// liste de qualités provenant de ma liste sur http://martouf.ch/document/88-liste-de-qualites.html en date du 1 avril 2011.
	$qualities = array();
	$qualities['a'] = array("abordable","accessible","accueillant","actif","accompli","admirable","adorable","adroit","affable","affectueux","affirmatif","agréable","aidant","aimable","aimant","amusant","ambitieux","amical","animé","apaisant","appliqué","ardent","artistique","assidu","astucieux","attachant","attentif (aux autres)","attentionné","attractif","audacieux","autonome","authentique","aventureux");
	$qualities['b'] = array("beau","bienfaisant","bienséant","bienveillant","bon","brave","brillant");
	$qualities['c'] = array("calme","capable","captivant","chanceux","chaleureux","charismatique","charmant","charmeur","civil","clément","cohérente","collaborateur","communicatif","concerné","conciliant","confiant","constant","content","conséquent","convaincant","convenable","coopératif","courageux","courtois","consciencieux","combatif","compréhensif","compatissant","complaisant","complice","créatif","curieux");
	$qualities['d'] = array("débonnaire","débrouillard","décidé","décideur","délicat","détendu","déterminé","dévoué","digne (de confiance)","diplomate","discret","discipliné","disponible","distingué","direct","dévoué","divertissant","distrayant","doux","dynamique","droit","drôle");
	$qualities['e'] = array("éblouissant","éclatant","économe","édifiant","efficace","égayant","encourageant","enjoué","énergique","engagé","enthousiaste","empathique","émouvant","épanoui","équilibré","équitable","érudit","espiègle","étincelant","étonnant","euphorique","éveillé","exaltant","exact","exemplaire","explicite","expressif","exubérant");
	$qualities['f'] = array("facile","fantaisiste","fantastique","fascinant","ferme","fiable","fidèle","fin","flamboyant","flexible","fort","formidable","fou","franc");
	$qualities['g'] = array("gai","gagnant","galant","gentil","généreux","génial","gracieux","grand","grandiose");
	$qualities['h'] = array("habile","hardi","héroïque","heureux","honnête","honorable","hospitalier","humain","humble","humoristique");
	$qualities['i'] = array("idéaliste","indulgent","indomptable","indépendant","influent","ingénieux","insouciant","inspiré","inoubliable","intelligent","intéressé","intrépide","inventif","imaginatif","impliqué");
	$qualities['j'] = array("joueur","jovial","joyeux","judicieux","juste");
	$qualities['k'] = array("kyrielle de qualités");
	$qualities['l'] = array("libéré","libre","loyal","logique","lucide");
	$qualities['m'] = array("magnifique","magistral","malin / maligne","marrant","mature","méthodique","merveilleux","minutieux","mignon","modèle","modeste","moral","motivé");
	$qualities['n'] = array("naturel","noble","novateur","nuancé");
	$qualities['o'] = array("obligeant","objectif","observateur","obstiné","opiniâtre","optimiste","ordonné","organisé","organisateur","ouvert (d\'esprit)","ordré","original");
	$qualities['p'] = array("pacifique","paisible","pardonnant","parfait","passionné","passionnant","patient","penseur","perfectionniste","perspicace","persévérant","persuasif","pétillant","planificateur","philosophe","plein d\'idée","poli","polyvalent","pondéré","ponctuel","posé","positif","présent","pragmatique","pratique","précis","probe","productif","propre","protecteur","prudent");
	$qualities['q'] = array("(plein de) qualités");
	$qualities['r'] = array("radieux","raffiné","raisonnable","rassurant","rayonnant","réfléchi","réaliste","réceptif","réconfortant","reconnaissant","réservé","résolu","responsable","respectueux","rigolo","rigoureux","romantique","rusé");
	$qualities['s'] = array("sage","savant","serein","sensible","serviable","sérieux","sexy !","sincère","social","sociable","solide","souple","souriant","spirituel","spontané","sportif","stable","stimulant","stupéfiant","structuré","sûr de soi","super","sympathique");
	$qualities['t'] = array("talentueux","tranquille","tenace","tendre","tempéré","tolérant","travailleur","travaillant (= travailleur en québécois !)");
	$qualities['u'] = array("unique","utile");
	$qualities['v'] = array("vrai","vaillant","valeureux","vigilant","vigoureux","vivant","volontaire");
	$qualities['w'] = array("waouh !");
	$qualities['x'] = array("X fois plein de qualité","Xtraordinaire");
	$qualities['y'] = array("yin","yang","yoda","yeah !");
	$qualities['z'] = array("zen");

	$text = strtolower($text);
	$text = simplifieNom($text);

	// transforme le text en tableau.
	$letters = str_split($text);

	$acrostic = array();

	// pour chaque lettre trouve et attribue une qualité
	foreach ($letters as $key => $letter) {
		$max = count($qualities[$letter])-1;
		$randomNumber = rand(0,$max);
		$acrostic[] = $qualities[$letter][$randomNumber];
	}
	return $acrostic;
}


function displayAcrosticheForm($atts=''){
	// récupération des attributs et transformation en variables
//	extract(shortcode_atts(array('id'=>'','title'=>''), $atts));
	
	$acrostichejsCode = '<script type="text/javascript" src="/wp-content/plugins/acrostiche/acrostiche.js"></script>';
	$acrostichejsCode .= '<script type="text/javascript">';
	$acrostichejsCode .= 'var chemin = "//'.$_SERVER['SERVER_NAME'].'/"';
	$acrostichejsCode .= '</script>';

	$htmlForm  = '<div id="blocAcrostiche">';
	$htmlForm .=	'<label for="prenom">Entrez un prénom: </label><input id="prenom" name="prenom" type="text" />';
	$htmlForm .=		'<div id="resultatAcrostiche">&nbsp;</div>';
	$htmlForm .=	'<a id="boutonGenererAcrostiche" href="#"><img title="générer un nouvel acrostiche..." src="/wp-content/plugins/acrostiche/cog_edit.png" alt="générer" />&nbsp;(re)générer un acrostiche</a>';
	$htmlForm .= '</div>';
	
	return $acrostichejsCode.$htmlForm;
}

/* Permet de supprimer ou modifier tout les caractères qui pourraient poser des
 * problèmes lors de leur utilisation comme nom de fichier.
 * Il s'agit du remplacement des caractère accentué par leur équivalent non accentué. (fonctionne en utf-8)
 * Du remplacement des espaces par des _
 * Du remplacement des ' par des _
 *
 * @return: string le nom du fichier simplifié
 * @param: $nomFichier string le nom du fichier que l'on veut simplifier
 */
function simplifieNom($nomFichier){
	// enlève les accents
	$a = 'ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÚÛÜÝÞßàáâãäåæçèéêëìíîïðñòóôõöøùúûýýþÿŔŕ'; 
    $b = 'aaaaaaaceeeeiiiidnoooooouuuuybsaaaaaaaceeeeiiiidnoooooouuuyybyRr'; 
    $nomFichier = utf8_decode($nomFichier);     
    $nomFichier = strtr($nomFichier, utf8_decode($a), $b); 
    $nomFichier = strtolower($nomFichier); 
    $nomFichier = utf8_encode($nomFichier);	

	// remplace les espaces par des _
	$nomFichier = preg_replace("/\s/","-",$nomFichier);
	// supprim les antislashes d'échappement des '
	$nomFichier = stripslashes($nomFichier);
	// Remplace les apostrophes par des _
	$nomFichier = preg_replace("/\'/","-",$nomFichier);

	return $nomFichier;
}

?>