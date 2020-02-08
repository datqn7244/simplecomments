{if $enable_grades==1 AND isset($grade)}
<p class="simple-grade">
{for $foo=1 to $grade}
⭐
{/for}
</p> 
{/if}