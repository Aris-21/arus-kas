<footer class="footer">
    &COPY; <?= date("Y") ?> <a href="http://aurakompakuntansi.com">aura</a>.
</footer>


<div class="loader-wrapper" id="loader">
    <div class="load-content">
        Mohon tunggu ...
        <br>
        <br>
        <div class="progress">
            <div class="progress-bar progress-bar-striped active" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%">
                <span class="sr-only"></span>
            </div>
        </div>
    </div>
</div>

<style>
    .loader-wrapper{
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: rgba(0,0,0,0.3);
        z-index: 2000;
        display: none;
    }
    
    .loader-wrapper .load-content{
        position: fixed;
        z-index: 2001;
        top: 50%;
        left: 50%;
        transform: translate(-50%,-50%);
        
        width: 300px;
        background-color: #fff;
        border-radius: 4px;
        text-align: center;
        padding: 10px;
        box-shadow: 2px 2px 10px rgba(0,0,0,0.3);
    }
</style>
