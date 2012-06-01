$(document).ready(function()
{
	$("#rechercheAutocomplete").autocomplete({ source: ["coucou", "hey"] });
});

function toutCocherDecocher()
{
	if($("#bCocher").attr("rel") == "cocher")
	{
		$(".checkTitre").each(function() { $(this).attr("checked", true); });
		$("#bCocher").attr("rel", "decocher");
	}
	else if($("#bCocher").attr("rel") == "decocher")
	{
		$(".checkTitre").each(function() { $(this).attr("checked", false); });
		$("#bCocher").attr("rel", "cocher");
	}
}
