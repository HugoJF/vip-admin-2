import React from 'react';

export default function Table({children, ...rest}) {
    return (
        <table {...rest} className="mt-8 w-full text-grey-darkest">
            {children}
        </table>
    );
}