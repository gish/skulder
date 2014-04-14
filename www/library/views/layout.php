<!DOCTYPE html>
<html lang="en">
<head>
    <title>Skulder</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0,maximum-scale=1.0">
    <link rel="apple-touch-icon" href="/images/apple-touch-icon.png" />
    <link rel="stylesheet" href="/bootstrap/css/bootstrap.min.css" type="text/css">
    <link rel="stylesheet" href="/bootstrap/css/bootstrap-responsive.min.css" type="text/css">
    <link rel="stylesheet" href="/css/default.css" type="text/css">
    <script type="text/javascript" src="/js/lib/jquery-1.7.2.min.js"></script>
    <script type="text/javascript" data-main="/js/app.js" src="/js/lib/require.min.js"></script>
<body>
<div class="container">
    <div class="row-fluid">
        <div id="message-container"></div>
        <div class="row-fluid">
            <div class="span6">
                <h2>Aktuell status</h2>
                <div id="status-message"></div>
            </div>
            <div class="span6"><?php echo $content ?></div>
        </div>
        <div class="row-fluid">
            <h2>Skulder</h2>
            <div id="table-container">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Person</th>
                        <th class="hidden-phone">Datum</th>
                        <th>Inköpt</th>
                        <th>Skuld</th>
                        <th class="hidden-phone">Kostnad</th>
                        <th></th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="7">
                            <button class="btn btn-primary" id="load-debts">Ladda fler</button>
                        </td>
                    </tr>
                <tfoot>
            </table>
        </div>
    </div>
</div>
<script type="text/template" id="debt-template">
    <td><%= debt.get('name') %></td>
    <td class="hidden-phone"><%= debt.get('date') %></td>
    <td><%= debt.get('description') %></td>
    <td><%= Math.round(debt.get('sum')*debt.get('share')*100)/100 %></td>
    <td class="hidden-phone"><%= debt.get('share')*100 %>% av <%= debt.get('sum') %></td>
    <!--<td>
        <a href="#" id="edit-<%= debt.id %>" class="edit"><i class="icon-edit"></i></a>
    </td>-->
    <td>
        <% if ("0" == debt.get('deleted')) { %>
            <a href="#" id="remove-<%= debt.id %>" class="remove"><i class="icon-remove"></i></a>
        <% } else { %>
            <a href="#" id="restore-<%= debt.id %>" class="restore"><i class="icon-ok"></i></a>
        <% } %>
    </td>
</script>
<script type="text/template" id="message-template">
    <div class="alert alert-<%= message.get('type') %>">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
        <%= message.get('content') %>
    </div>
</script>
<script type="text/template" id="own-template">
    <%= name %> är skyldig <em><%= sum %></em> kr.
</script>
<script type="text/template" id="own-template-loading">
    Laddar...
</script>
<script type="text/template" id="change-debt-template">
<div class="modal" id="change-debt">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">×</button>
        <h3>Ändra skuld</h3>
    </div>
    <div class="modal-body">
        <form method="post" id="add-form" action="/" class="well form-inline">
            <select name="name">
                <option <%= (debt.name == "<?php echo $settings['users'][0]; ?>" ? 'selected="selected"') %>><?php echo $settings['users'][0]; ?></option>
                <option <%= (debt.name == "<?php echo $settings['users'][1]; ?>" ? 'selected="selected"') %>><?php echo $settings['users'][1]; ?></option>
            </select>
            är skyldig
            <div class="input-append">
                <input type="tel" name="share" maxlength="3" value="<%= debt.share %>">
                <span class="add-on">%</span>
            </div>
            av
            <div class="input-append">
                <input type="tel" name="sum" value="<%= debt.sum %>">
                <span class="add-on">kr</span>
            </div>
            för
            <input type="text" name="description" placeholder="Vad som köptes" value="<%= debt.description %>">
            <input type="date" name="date" value="<%= debt.date %>">
            <button type="submit" class="btn btn-primary"><i class="icon-check"></i> Lägg till</button>
        </form>
    </div>
    <div class="modal-footer">
      <a href="#" class="btn" data-dismiss="modal">Stäng</a>
      <a href="#" class="btn btn-primary">Ändra</a>
    </div>
</div>
</script>
</body>
</html>
