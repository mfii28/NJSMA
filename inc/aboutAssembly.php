<?php
// Fetch assembly info from database or use global settings
$assemblyLegalFramework = $GLOBAL_SETTINGS['assembly_legal_framework'] ?? '';
$assemblyPopulation = $GLOBAL_SETTINGS['assembly_population'] ?? '';
$assemblyStructure = $GLOBAL_SETTINGS['assembly_structure'] ?? '';
$assemblyMission = $GLOBAL_SETTINGS['assembly_mission'] ?? '';
$assemblyVision = $GLOBAL_SETTINGS['assembly_vision'] ?? '';
$assemblyFunctions = $GLOBAL_SETTINGS['assembly_functions'] ?? '';

// Check if we have dynamic content
$hasDynamicContent = !empty($assemblyLegalFramework) || !empty($assemblyPopulation) || !empty($assemblyMission);
?>
<!-- Assembly Details Section -->
<section class="the-assembly-details-area">
    <div class="container">
        <div class="row">
            <div class="col-12"><h2>The Assembly</h2></div>
            <div class="col-lg-9 main-text">
                <div class="main-text-wrap">
                    <?php if ($hasDynamicContent): ?>
                        <?php if (!empty($assemblyLegalFramework)): ?>
                        <h3>Legal Framework</h3>
                        <?= $assemblyLegalFramework ?>
                        <?php endif; ?>
                        
                        <?php if (!empty($assemblyPopulation)): ?>
                        <h3>Population</h3>
                        <?= $assemblyPopulation ?>
                        <?php endif; ?>
                        
                        <?php if (!empty($assemblyStructure)): ?>
                        <h3>Administrative Structure</h3>
                        <?= $assemblyStructure ?>
                        <?php endif; ?>
                        
                        <?php if (!empty($assemblyMission)): ?>
                        <h3>Mission</h3>
                        <?= $assemblyMission ?>
                        <?php endif; ?>
                        
                        <?php if (!empty($assemblyVision)): ?>
                        <h3>Vision</h3>
                        <?= $assemblyVision ?>
                        <?php endif; ?>
                        
                        <?php if (!empty($assemblyFunctions)): ?>
                        <h3>Core Functions</h3>
                        <?= $assemblyFunctions ?>
                        <?php endif; ?>
                    <?php else: ?>
                        <h3>Legal Framework</h3>
                        <p>The New Juaben South Municipal Assembly (NJSMA) is one of the Two Hundred and Sixty-One (261) Metropolitan, Municipal and District Assemblies (MMDAs) in Ghana. It was established under the Local Government Act, 1993 (Act 462), which has been amended as the Local Governance Act, 2016 (Act 936).</p>
                        
                        <h3>Administrative Structure</h3>
                        <p>The Assembly is headed by the Municipal Chief Executive (MCE) who is the political and administrative head. The General Assembly comprises elected members, government appointees, Members of Parliament, and the MCE. The Presiding Member heads the General Assembly meetings.</p>
                        <p>The Assembly operates through various sub-committees including: Finance and Administration, Development Planning, Social Services, Works, Environment, and Justice and Security.</p>
                        
                        <h3>Mission</h3>
                        <p>To improve the quality of life of the people through efficient and effective mobilization of both human and material resources for the provision of socio-economic services and infrastructure.</p>
                        
                        <h3>Vision</h3>
                        <p>A model Municipal Assembly with a sustainable economy and high quality of life for all residents.</p>
                        
                        <h3>Core Functions</h3>
                        <ul>
                            <li>Responsible for overall development of the municipality</li>
                            <li>Formulate and execute plans and strategies for resource mobilization</li>
                            <li>Promote and support productive activities and social development</li>
                            <li>Develop basic infrastructure and provide municipal works</li>
                            <li>Manage human settlements and the environment</li>
                            <li>Maintain security and public safety</li>
                            <li>Preserve and promote cultural heritage</li>
                        </ul>
                    <?php endif; ?>
                </div>
            </div> <!-- End .main-text -->
            <div class="col-lg-3 other-links d-none d-lg-block">
                <div class="other-links-wrap">
                    <h3>Other Links</h3>
<ul>
            <!-- <li><a href="department-details.php?d="></a></li> -->
        <li><a href="/njsma/assemblyInfo">The Assembly</a></li>
    <li><a href="/njsma/MCE">The MCE</a></li>
    <li><a href="/njsma/assembly-members">Assembly Members</a></li>
    <li><a href="/njsma/history">The History</a></li>
</ul>                </div>
            </div>
        </div> <!-- End .row -->
    </div> <!-- End .container -->
</section> <!-- End .the-assembly-details-area -->        <!-- End of Sub Metros Area -->