<?php
	defined( 'ceditFinder' ) or die( 'Restricted access' );
?>
</div>
</body>
<script type="text/javascript">
function getWindowHeight() {
	if (self.innerHeight) return self.innerHeight;
	if (document.documentElement && document.documentElement.clientHeight)
		return  document.documentElement.clientHeight;
	if (document.body) return document.body.clientHeight;

	return -1;
}
var w=getWindowHeight();
var f=document.getElementById('folderview');
var t=document.getElementById('foldertree');
var b=document.getElementById('browsertitle');
var h=w-b.offsetHeight;
if (f.offsetHeight>t.offsetHeight) {
	t.style.overflow='scroll';
	if (f.offsetHeight<=h) { f.style.overflow='hidden';} else f.style.overflow='scroll';;
} else {
	f.style.overflow='scroll';
	if (t.offsetHeight<=h) { t.style.overflow='hidden';} else t.style.overflow='scroll';;
}
f.style.height=h+'px';
t.style.height=h+'px';
</script>

</html>
<?php mysql_close() ?>