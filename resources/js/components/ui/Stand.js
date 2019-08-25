import React from 'react';

export default function Stand({children}){
    return (
        <table className="table-fixed w-full text-grey-darkest">
            <tbody>
            {children}
            </tbody>
        </table>
    );
}