var TIT
var DES
var DIV
var BT
var geo
var localisation
var date
var type
var surface
var prix
var etat
var element
controller()
function controller()
{
	initialisation()
	defaut()
	
	BT.addEventListener("click",function(event)
	{
		switch(etat)
		{
			case 0 : localisation()
			break
			case 1 : date()
			break
			case 2 : type()
			break
			case 3 : construction()
			break
			case 4 : renovation()
			break
			case 5 : pose()
			break
			case 6 : surface()
			break
			case 7 : prix()
			break
		}
	})

}

function initialisation()
{
	TIT = document.getElementById('titre') //Titre
	DES = document.getElementById('description') //Descritpion
	DIV = document.getElementById('divers') //Divers
	BT = document.getElementById('bouton') //Boutton
	geo = navigator.geolocation
}

function defaut()
{
	TIT.innerHTML="Creation d'un devis gratuit"
	DES.innerHTML="Attention, creer le devis gratuit ne vous donne seulement un aperçu du prix, pour un devis précis, merci de me contacter via mon adresse mail ou via mon numéro de portable"
	BT.innerHTML="Commencer"
	etat = 0
}	
function localisation()
{
	TIT.innerHTML="Localisation du chantier"
	DES.innerHTML="Où se trouve le chantier à réaliser ?"
	element = document.createElement("EditText")
	BT.innerHTML="Suivant"
	etat = 1


}
function date()
{
	TIT.innerHTML="Début du chantier"
	DES.innerHTML="Quand débutera votre chantier ?"
	etat = 2

}
function type()
{
	TIT.innerHTML="Type de chantier"
	DES.innerHTML="Quelle type de chantier faudrat il executer ?"
	etat = 3
}
function construction()
{
	TIT.innerHTML="Construction"
	DES.innerHTML="Type de construction"
	etat = 4
}
function renovation()
{
	TIT.innerHTML="Type de renovation"
	DES.innerHTML="dfenjienijeni"
	etat = 5
}
function pose()
{
	TIT.innerHTML="Pose"
	DES.innerHTML="Type de pose"
	etat = 6
}
function surface()
{
	TIT.innerHTML="Surface"
	DES.innerHTML="Type de description"
	etat = 7
}
function prix()
{
	TIT.innerHTML="Le prix"
	DES.innerHTML="Le prix"
	etat = 8
}
