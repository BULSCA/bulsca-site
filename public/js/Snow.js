let NUMBER_OF_SNOWFLAKES = 1000;
let MAX_SNOWFLAKE_SIZE = 3;
let MAX_SNOWFLAKE_SPEED = 2;
const SNOWFLAKE_COLOUR = "#ddd";

MOUSE_X = 0;
MOUSE_Y = 0;

let snowflakes = [];

letItSnow = () => {
    const prefersReducedMotion = window.matchMedia(
        "(prefers-reduced-motion: reduce)"
    ).matches;
    if (prefersReducedMotion) {
        console.log(
            "Reduced motion preference detected. No snow will be displayed."
        );
        return;
    }

    const setSnowflakesByScreenWidth = () => {
        let screenWidth = window.innerWidth;

        if (screenWidth > 1080) {
            NUMBER_OF_SNOWFLAKES = 500;
        } else if (screenWidth > 500) {
            NUMBER_OF_SNOWFLAKES = 250;
        } else {
            NUMBER_OF_SNOWFLAKES = 125;
        }
    };

    setSnowflakesByScreenWidth();

    const canvas = document.createElement("canvas");
    canvas.style.position = "absolute";
    canvas.style.pointerEvents = "none";
    canvas.style.top = "0px";
    canvas.style.overflow = "hidden";
    canvas.width = window.innerWidth;
    canvas.height = window.innerHeight;

    document.body.appendChild(canvas);

    const ctx = canvas.getContext("2d");

    const createSnowflake = () => ({
        x: Math.random() * canvas.width,
        y: 0,
        radius: Math.floor(Math.random() * MAX_SNOWFLAKE_SIZE) + 1,
        color: SNOWFLAKE_COLOUR,
        speed: Math.random() * MAX_SNOWFLAKE_SPEED + 1,
        sway: Math.random() - 0.5,
    });

    const drawSnowflake = (snowflake) => {
        ctx.beginPath();
        ctx.arc(snowflake.x, snowflake.y, snowflake.radius, 0, Math.PI * 2);
        ctx.fillStyle = snowflake.color;
        ctx.fill();
        ctx.closePath();
    };

    const updateSnowflake = (snowflake) => {
        distance = distanceFromMouse(snowflake.x, snowflake.y);

        // if (distance < 100) {
        //     moveToLeft = snowflake.x <= MOUSE_X;
        //     moveDown = snowflake.y >= MOUSE_Y;

        //     snowflake.x += 30 * (moveToLeft ? -1 : 1);
        //     snowflake.y += snowflake.speed * 0.7;

        //     //snowflake.y += snowflake.speed;
        // } else {
        middle = window.innerWidth / 2;
        distanceFromMiddle = middle - MOUSE_X;

        swayDir = distanceFromMiddle / middle;

        snowflake.y += snowflake.speed;
        snowflake.x += snowflake.sway;
        // }

        if (snowflake.x > canvas.width) {
            snowflake.x = 0;
        }

        if (snowflake.x < 0) {
            snowflake.x = canvas.width;
        }

        if (snowflake.y > canvas.height) {
            Object.assign(snowflake, createSnowflake());
        }
    };

    const distanceFromMouse = (x, y) => {
        return Math.sqrt((MOUSE_X - x) ** 2 + (MOUSE_Y - y) ** 2);
    };

    const animate = () => {
        ctx.clearRect(0, 0, canvas.width, canvas.height);

        snowflakes.forEach((snowflake) => {
            drawSnowflake(snowflake);
            updateSnowflake(snowflake);
        });

        requestAnimationFrame(animate);
    };

    animate();

    if (localStorage.getItem("snow") != null) {
        snowflakes = JSON.parse(localStorage.getItem("snow"));
    }

    let interval = setInterval(() => {
        if (snowflakes.length > NUMBER_OF_SNOWFLAKES) {
            snowflakes.pop();
        } else {
            snowflakes.push(createSnowflake());
        }
    }, 50);

    window.addEventListener("resize", () => {
        canvas.width = window.innerWidth;
        canvas.height = window.innerHeight;

        setSnowflakesByScreenWidth();
    });

    window.addEventListener("scroll", () => {
        canvas.style.top = `${window.scrollY}px`;
    });

    window.addEventListener("mousemove", (e) => {
        MOUSE_X = e.clientX;
        MOUSE_Y = e.clientY;
    });

    setInterval(() => {
        localStorage.setItem("snow", JSON.stringify(snowflakes));
    }, 500);

    setInterval(() => {
        MAX_SNOWFLAKE_SIZE = Math.max(2, Math.random() * 5);
        MAX_SNOWFLAKE_SPEED = Math.max(1, Math.random() * 3);
    }, 5000);
};
