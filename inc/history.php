<!-- History Content -->
<section class="the-assembly-details-area">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h2>The History of the Assembly</h2>
                <?php if (!empty($GLOBAL_SETTINGS['history_established_year'])): ?>
                <p class="text-muted">Established <?= htmlspecialchars($GLOBAL_SETTINGS['history_established_year']) ?></p>
                <?php endif; ?>
            </div>
            <div class="col-lg-12 main-text">
                <div class="main-text-wrap">
                    <?php if (!empty($GLOBAL_SETTINGS['history_content'])): ?>
                        <?= $GLOBAL_SETTINGS['history_content'] ?>
                    <?php else: ?>
                        <p>The New Juaben South Municipal Assembly was established to bring efficient local governance to the people of the municipality. Over the years, it has grown to become a key administrative body in the Eastern Region of Ghana.</p>
                        <p>The Assembly has been instrumental in various development projects including infrastructure improvements, education support, health service delivery, and economic empowerment programs for residents.</p>
                        <h3>Governance</h3>
                        <p>The Assembly operates under the Local Governance Act, working to provide decentralized administration and bring government services closer to the people.</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</section><!-- End .the-history-detail-->        