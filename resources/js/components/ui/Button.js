import React from 'react';

const colors = (color, hollow) => ({
    blue: `${hollow ? 'text-blue-dark' : 'text-blue-lightest'} border-blue ${!hollow && 'bg-blue'} ${hollow && 'hover:text-blue-lightest'} hover:bg-blue-dark hover:border-blue-dark`,
    green: `${hollow ? 'text-green-dark' : 'text-green-lightest'} border-green ${!hollow && 'bg-green'} ${hollow && 'hover:text-green-lightest'} hover:bg-green-dark hover:border-green-dark`,
    red: `${hollow ? 'text-red-dark' : 'text-red-lightest'} border-red ${!hollow && 'bg-red'} ${hollow && 'hover:text-red-lightest'} hover:bg-red-dark hover:border-red-dark`,
    white: `${hollow ? 'text-grey-dark' : 'text-grey-darkest'}  border-grey ${!hollow && 'bg-grey-lightest'} ${hollow && 'hover:text-grey-lightest'} hover:bg-grey-lighter hover:border-grey`,
});

const sizes = () => ({
    lg: "px-10 py-2 text-3xl font-semibold",
    base: "px-5 py-1 text-xl font-semibold",
    sm: "px-3 py-1 text-sm font-medium",
    xs: "px-1 py-1 text-sm font-medium",
});

const shadows3D = (color, size) => (
    `shadow-3d-${color}-${size}`
);

const pulses = (color) => (
    `pulse-${color}`
);

const borders = (border) => {
    return border.reduce((res, b) => (
        res + `border-${b} `
    ), '');
};

export default function Button({
                                   size = 'base',
                                   shadow3D = false,
                                   hollow = false,
                                   color = 'white',
                                   pulse = false,
                                   border = ['t', 'l', 'b', 'r'],
                                   children,
                                   onClick,
                               }) {
    let colorCss = colors(color, hollow)[color];
    let sizeCss = sizes()[size];
    let shadow3DCss = shadow3D && shadows3D(color, size);
    let pulseCss = pulses(color);
    let borderCss = borders(border);

    return (
        <div className={`${pulse && pulseCss}`}>
            <a onClick={onClick} href="#" className={`trans h-full inline-block ${shadow3DCss} ${borderCss} ${sizeCss} text-center cursor-pointer ${colorCss} no-underline`}>
                {children}
            </a>
        </div>
    );
}