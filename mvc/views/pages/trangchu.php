<?php
    $dt = json_decode($data['BS'], true);
    $dt2 = json_decode($data['CK'], true);
?>


<div class="listbs">
    
        <div class="booking">
                <h1>Đặt khám bác sĩ</h1>
                <p>Phiếu khám kèm số thứ tự và thời gian của bạn được xác nhận.</p>
                <div class="list" id="doctorList">
                <?php foreach ($dt as $r): ?>
                    <div class="bs_card">
                        <a href="" style="text-decoration: none">
                        <img src="public/img/<?=$r["img"]?>" alt="" class="image">
                        <div class="bs_info">
                            <h2 class="name"><?=$r["HovaTen"]?></h2>
                            <p class="department"><?=$r["TenKhoa"]?></p>
                        </div>
                        </a>
                    </div>
                <?php endforeach; ?>
                </div>
                <button class="see-more-button">Xem thêm ></button>
                <button id="scrollLeftDoctor" class="scroll-button" aria-label="Scroll left">&lt;</button>
                <button id="scrollRightDoctor" class="scroll-button" aria-label="Scroll right">&gt;</button>
            </div>
        
        </div>
        <div class="listpk">
            <div class="booking">
                    <h1>Đặt khám chuyên khoa</h1>
                    <p>Đa dạng phòng khám với nhiều chuyên khoa khác nhau như Sản - Nhi, Tai Mũi họng, Da Liễu, Tiêu Hoá...</p>
                    <div class="list" id="pkList">
                    <?php foreach ($dt2 as $r): ?>
                        <div class="bv_card">
                            <a href="" style="text-decoration: none">
                                <img src="public/img/<?=$r["img"]?>" alt="" class="image2"> <!-- Chỗ này để ảnh 300x150 dùm nhé-->
                                <div class="pk_info">
                                    <h2 class="name" style="text-align:center;"><?=$r["TenKhoa"]?></h2>
                                </div>
                            </a>
                        </div>  
                    <?php endforeach; ?>   
                    </div>
                    <button class="see-more-button">Xem thêm ></button>
                    <button id="scrollLeftPK" class="scroll-button" aria-label="Scroll left">&lt;</button>
                    <button id="scrollRightPK" class="scroll-button" aria-label="Scroll right">&gt;</button>
            </div>
        </div>
        <div class="new" >
        <h1>Tin tức y tế</h1>
        <div class="news-grid">
            <article class="news-card">
                <img src="https://via.placeholder.com/300x200?text=New+Cancer+Treatment" alt="New Cancer Treatment" class="news-image">
                <div class="news-content">
                    <h2 class="news-title">Breakthrough in Cancer Treatment Shows Promise</h2>
                    <p class="news-description">A new immunotherapy approach has shown remarkable results in early clinical trials, potentially revolutionizing cancer treatment.</p>
                    <a href="#" class="read-more">Read More</a>
                </div>
            </article>
            <article class="news-card">
                <img src="https://via.placeholder.com/300x200?text=COVID-19+Update" alt="COVID-19 Update" class="news-image">
                <div class="news-content">
                    <h2 class="news-title">COVID-19: New Variant Emerges, Vaccination Efforts Intensify</h2>
                    <p class="news-description">Health officials worldwide are monitoring a new COVID-19 variant while ramping up vaccination campaigns to curb its spread.</p>
                    <a href="#" class="read-more">Read More</a>
                </div>
            </article>
            <article class="news-card">
                <img src="https://via.placeholder.com/300x200?text=Mental+Health+Study" alt="Mental Health Study" class="news-image">
                <div class="news-content">
                    <h2 class="news-title">Study Reveals Link Between Exercise and Mental Health</h2>
                    <p class="news-description">New research underscores the significant impact of regular physical activity on mental well-being and cognitive function.</p>
                    <a href="#" class="read-more">Read More</a>
                </div>
            </article>
            <article class="news-card">
                <img src="https://via.placeholder.com/300x200?text=Telemedicine+Advancements" alt="Telemedicine Advancements" class="news-image">
                <div class="news-content">
                    <h2 class="news-title">Telemedicine Advancements Improve Rural Healthcare Access</h2>
                    <p class="news-description">Innovative telemedicine technologies are bridging the gap in healthcare accessibility for rural communities around the globe.</p>
                    <a href="#" class="read-more">Read More</a>
                </div>
            </article>
            <article class="news-card">
                <img src="https://via.placeholder.com/300x200?text=Nutrition+Research" alt="Nutrition Research" class="news-image">
                <div class="news-content">
                    <h2 class="news-title">New Dietary Guidelines: Emphasis on Plant-Based Nutrition</h2>
                    <p class="news-description">Updated nutritional recommendations highlight the benefits of plant-based diets in preventing chronic diseases and promoting longevity.</p>
                    <a href="#" class="read-more">Read More</a>
                </div>
            </article>
            <article class="news-card">
                <img src="https://via.placeholder.com/300x200?text=Medical+AI" alt="Medical AI" class="news-image">
                <div class="news-content">
                    <h2 class="news-title">AI in Medicine: Revolutionizing Diagnosis and Treatment</h2>
                    <p class="news-description">Artificial intelligence is making significant strides in medical imaging analysis and personalized treatment planning, enhancing healthcare outcomes.</p>
                    <a href="#" class="read-more">Read More</a>
                </div>
            </article>
        </div>
        </div>