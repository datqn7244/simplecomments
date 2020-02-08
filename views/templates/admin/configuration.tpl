{* Original form before I use helper form
<form method="POST">
    <div class="panel">
        <div class="panel-heading">
            {l s='Configuration' mod='simplecomments'}
        </div>
        <div class="panel-body">
            <label for="print"> {l s='Simple comments configuration screen' mod='simplecomments'}</label>
            <input type="text" name="print" id="print" class="form-control" value="{$token}" />
            <a href="index.php?controller=AdminOrigin&token={$token}">{$token}</a>
        </div>
        <div class="panel-footer">
            <button type="submit" name="savesimplecomments" class="btn btn-default pull-right">
                <i class="process-icon-save"></i>
                {l s='Save' mod='simplecomments'}
            </button>
        </div>
    </div>
</form> *}
{if isset($confirmation)}
<div class="alert alert-success">>{l s='Settings updated' mod='simplecomments'}</div>
{/if}
{* <fieldset>
    <h2>Simple Comments configuration</h2>
    <div class="panel">
        <div class="panel-heading">
            <legend><img src="../img/admin/cog.gif" alt="" width="16" />Configuration</legend>
        </div>
        <form action="" method="post">
            <div class="form-group clearfix">
                <label class="col-lg-3">Enable grades:</label>
                <div class="col-lg-9">
                    <img src="../img/admin/enabled.gif" alt="" />
                    <input type="radio" id="enable_grades_1" name="enable_grades" value="1" {if $enable_grades=='1'
                        }checked{/if} />
                    <label class="t" for="enable_grades_1">Yes</label>
                    <img src="../img/admin/disabled.gif" alt="" />
                    <input type="radio" id="enable_grades_0" name="enable_grades" value="0" {if empty($enable_grades) ||
                        $enable_grades == '0' }checked{/if} />
                    <label class="t" for="enable_grades_0">No</label>
                </div>
            </div>
            <div class="form-group clearfix">
                <label class="col-lg-3">Enable comments:</label>
                <div class="col-lg-9">
                    <img src="../img/admin/enabled.gif" alt="" />
                    <input type="radio" id="enable_comments_1" name="enable_comments" value="1" {if
                        $enable_comments=='1' }checked{/if} />
                    <label class="t" for="enable_comments_1">Yes</label>
                    <img src="../img/admin/disabled.gif" alt="" />
                    <input type="radio" id="enable_comments_0" name="enable_comments" value="0" {if
                        empty($enable_comments) || $enable_comments == '0' }checked{/if} />
                    <label class="t" for="enable_comments_0">No</label>
                </div>
            </div>
            <div class="panel-footer">
                <input class="btn btn-default pull-right" type="submit" name="simple_comments_form" value="Save" />
            </div>
        </form>
    </div>
</fieldset> *}