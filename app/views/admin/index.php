<section class="container">
    <h1 class="text-center">List of all the users deposits</h1>

    <div class="mt-3">
        <table class="table table-striped overflow-auto" id="deposit-list" style="max-height: 500px; ">
            <thead>
                <tr>
                    <th scope="col">Username</th>
                    <th scope="col">Amount</th>
                    <th scope="col">Date (d-m-Y)</th>
                    <th scope="col">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($deposits as $deposit) { ?>
                    <tr>
                        <td scope="row"><a href="/user/<?= $deposit['id_user'] ?>"><?= $deposit['name'] ?></a></td>
                        <td><?= $deposit['montant'] ?> $</td>
                        <td><?= $deposit['date'] ?></td>
                        <td>
                            <div class="d-flex gap-3">
                                <!-- deposit-id will be posted via ajax -->
                                <a href="/api/reject/deposit/" class="btn btn-outline-danger btn-sm w-50 reject-btn" data-deposit-id="<?= $deposit['id_move'] ?>">
                                    <i class="fa fa-trash"></i> Reject
                                </a>
                                <a href="/api/accept/deposit/" class="btn btn-success btn-sm w-50 accept-btn" data-deposit-id="<?= $deposit['id_move'] ?>">
                                    <i class="fa fa-check"></i> Accept
                                </a>
                            </div>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</section>