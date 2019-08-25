import React, {Component} from 'react';

export default function Tag({children, color = 'blue', pulse = false}) {
    let mod = color === 'yellow' ? '-dark' : '';

    return (
        <div className={`inline-block py-0 px-2 bg-${ color }${ mod } ${ pulse ? `pulse-${color}` : '' } font-semibold text-white text-sm rounded`}>
            {children}
        </div>
    );
}
