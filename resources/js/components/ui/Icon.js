import React from 'react';
import feather from "feather-icons";

export default function Icon({icon, classes = 'mr-1 w-4 h-4 text-grey-darkest', ...rest}) {
    return (
        <span {...rest} dangerouslySetInnerHTML={{__html: feather.icons[icon].toSvg({class: classes})}}/>
    );
}