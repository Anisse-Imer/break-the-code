<a href="" class="custom-link">&larr; Retour</a>
<div class="table-container">
    <div class="table-wrapper">
        <h2>Mes Statistiques</h2>
        <table>
            <table>
                <tr>
                    <th>Nom du Joueur</th>
                    <td><?php if($_SESSION["user"]->nom){echo $_SESSION["user"]->nom;}?></td>
                </tr>
                <tr>
                    <th>Nombre de partie</th>
                    <td><?php if($nombrePartie){ echo $nombrePartie; }?></td>
                </tr>
                <tr>
                    <th>Nombre de Victoire</th>
                    <td><?php echo $nombreVictoire; ?></td>
                </tr>
                <tr>
                    <th>Nombre de défaite</th>
                    <td><?php echo $nombreDefaite; ?></td>
                </tr>
                <tr>
                    <th>Ratio V/D</th>
                    <td><?php echo $ratio; ?> %</td>
                </tr>
            </table>
        </table>
    </div>
</div>