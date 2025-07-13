<?= $this->extend('layout') ?>
<?= $this->section('content') ?>


<section class="section faq">
    <div class="row">
        <div class="col-lg-12">
            <div class="card basic">
                <div class="card-body">
                    <h5 class="card-title">Pertanyaan yang Sering Diajukan</h5>

                    <div class="accordion accordion-flush" id="faqAccordion">
                        <?php if (!empty($faqs)) : ?>
                            <?php foreach ($faqs as $index => $faq) : ?>
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="heading<?= $index ?>">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse<?= $index ?>" aria-expanded="false" aria-controls="collapse<?= $index ?>">
                                            <?= $faq['question'] ?>
                                        </button>
                                    </h2>
                                    <div id="collapse<?= $index ?>" class="accordion-collapse collapse" aria-labelledby="heading<?= $index ?>" data-bs-parent="#faqAccordion">
                                        <div class="accordion-body">
                                            <?= $faq['answer'] ?>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php else : ?>
                            <p>Belum ada pertanyaan yang sering diajukan saat ini.</p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?= $this->endSection() ?>