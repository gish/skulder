<h2>Lägg till skuld:</h2>
<form method="post" id="add-form" action="/" class="well form-inline">
    <select name="name">
        <option>Åsa</option>
        <option>Erik</option>
    </select>
    är skyldig
    <div class="input-append">
        <input type="tel" name="share" maxlength="3">
        <span class="add-on">%</span>
    </div>
    av
    <div class="input-append">
        <input type="tel" name="sum">
        <span class="add-on">kr</span>
    </div>
    för
    <input type="text" name="description" placeholder="Vad som köptes">
    <button type="submit" class="btn btn-primary"><i class="icon-check"></i> Lägg till</button>
</form>