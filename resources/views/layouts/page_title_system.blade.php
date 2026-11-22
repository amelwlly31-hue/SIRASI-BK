<style>
    :root {
        --sirasi-page-title-color: #17233b;
        --sirasi-page-title-accent: #3b6dcf;
    }

    .sirasi-global-page-title {
        position: relative;
        display: flex;
        min-width: 0;
        max-width: min(58vw, 760px);
        flex: 1 1 auto;
        align-items: center;
        align-self: stretch;
        padding: 8px 12px 9px 17px;
        overflow: hidden;
        color: var(--sirasi-page-title-color);
        font-size: clamp(20px, 2vw, 26px);
        font-weight: 700;
        letter-spacing: .01em;
        line-height: 1.05;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    .sirasi-global-page-title::before {
        position: absolute;
        top: 20%;
        bottom: 20%;
        left: 0;
        width: 3px;
        border-radius: 99px;
        background: linear-gradient(180deg, #89b4ff, var(--sirasi-page-title-accent), #244a9b);
        content: "";
    }

    .sirasi-global-page-title::after {
        position: absolute;
        bottom: 6px;
        left: 17px;
        width: 42px;
        height: 1px;
        background: linear-gradient(90deg, var(--sirasi-page-title-accent), rgba(59, 109, 207, 0));
        content: "";
    }

    .sirasi-page-title-source { display: none !important; }
    body.dark-mode { --sirasi-page-title-color: #edf3ff; --sirasi-page-title-accent: #8db4ff; }

    .page-banner h1,
    .hero-title {
        position: relative;
        font-weight: 700;
        letter-spacing: .005em;
        text-wrap: balance;
    }

    .page-banner h1::after,
    .hero-title::after {
        display: block;
        width: clamp(42px, 8vw, 76px);
        height: 2px;
        margin-top: .2em;
        border-radius: 999px;
        background: linear-gradient(90deg, var(--sirasi-page-title-accent), rgba(59, 109, 207, .12));
        content: "";
    }

    .page-header > h1,
    .page-header h1 {
        font-weight: 700;
        letter-spacing: .005em;
        text-wrap: balance;
    }

    .page-header h1::after {
        display: block;
        width: 48px;
        height: 2px;
        margin-top: .18em;
        border-radius: 999px;
        background: linear-gradient(90deg, var(--sirasi-page-title-accent), rgba(59, 109, 207, .12));
        content: "";
    }

    @media (max-width: 600px) {
        .sirasi-global-page-title {
            max-width: min(50vw, 320px);
            padding-left: 12px;
            font-size: 18px;
            white-space: normal;
        }
        .sirasi-global-page-title::after { left: 12px; }
    }
</style>
@include('partials.typography')
