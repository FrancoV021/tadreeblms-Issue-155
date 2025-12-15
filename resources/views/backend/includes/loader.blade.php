<style>
    .loader-overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5);
        /* Transparent black background */
        justify-content: center;
        align-items: center;
        z-index: 9999;
        /* Make sure it's above other content */
    }

    .loader-text {
        color: #fff;
        font-size: 24px;
        font-family: Arial, sans-serif;
        text-align: center;
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
    }
</style>
<div class="loader-overlay d-none" id="loader">
    <div class="loader-text">@lang('Please wait')...</div>
</div>
