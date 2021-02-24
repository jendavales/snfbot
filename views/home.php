<main class="content">
    <div class="container-fluid p-0">
        <div class="row">
            <div class="col-sm-12 offset-sm-0 offset-md-2 col-md-8">
                <div class="row mb-3">
                    <div class="col-auto ml-auto">
                        <button class="btn btn-warning">Spravovat profily</button>
                        <button class="btn btn-success">Přidat účet</button>
                    </div>
                </div>

                <?php /** @var $account \Models\Account */ ?>
                <?php foreach ($accounts as $account): ?>
                    <div class="card w-100 mb-4">
                        <div class="card-body w-100">
                            <div class="row">
                                <div class="col-2">
                                    <div class="character">
                                        <?php foreach ($account->getOutfitImages() as $image): ?>
                                                <img src="<?php echo $image ?>" class="part">
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                                <div class="col-10">
                                    <div class="row">
                                        <div class="col-auto"><h5><?php echo "$account->name - $account->level (".$account->getLevelProgress()."%)"?></h5></div>
                                        <div class="col-auto ml-auto display-flex">
                                            <select class="custom-select">
                                                <option value="<?php echo \Models\Account::PROFILE_NONE ?>"></option>
                                                <?php /** @var $profile \Models\Profile */ ?>
                                                <?php foreach ($profiles as $profile): ?>
                                                    <option value="<?php echo $profile->id ?>"><?php echo $profile->name ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row mt-2">
                                        <div class="col-8">
                                            <div class="row"><div class="text-small col-auto"><b>Status:</b> <?php echo $account->energy == 0 ? 'Hotovo' : 'Probíhá' ?></div></div>
                                            <div class="row"><div class="w-100 col-auto"><div class="progress mt-1 ">
                                                        <div class="progress-bar <?php if ($account->energy == 0) echo 'bg-success' ?>" role="progressbar"
                                                             style="width: <?php echo 100 - $account->energy ?>%" aria-valuenow="<?php echo 100 - $account->energy ?>" aria-valuemin="0"
                                                             aria-valuemax="100"></div></div>
                                                </div></div>
                                        </div>
                                        <div class="col-auto ml-auto"><i class="fas fa-map-marked-alt mt-4"></i> <?php echo $account->adventures ?>/<?php echo \Models\Profile::MAX_ADVENTURES ?></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</main>
