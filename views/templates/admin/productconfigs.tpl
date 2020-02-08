    <h2>Simple Comments configuration</h2>
            <div class="form-group clearfix">
                <label class="col-lg-3">Enable Reviews:</label>
                <div class="col-lg-9">
                    <img src="../img/admin/enabled.gif" alt="" />
                    <input type="radio" id="enable_reviews_1" name="enable_reviews" value="1" {if $enable_reviews=='1'
                        }checked{/if} />
                    <label class="t" for="enable_reviews_1">Yes</label>
                    <img src="../img/admin/disabled.gif" alt="" />
                    <input type="radio" id="enable_reviews_0" name="enable_reviews" value="0" {if empty($enable_reviews) ||
                        $enable_reviews == '0' }checked{/if} />
                    <label class="t" for="enable_reviews_0">No</label>
                </div>
            </div>
 
