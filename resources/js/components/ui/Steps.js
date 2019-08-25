import React, {Component} from 'react';

function StepProgressBar(props) {
    return (
        <div className="trans-slower absolute pin-t pin-l pin-b pin-r bg-grey-dark shadow overflow-hidden rounded-full">
            <div style={{width: `${props.progress * 100}%`}} className="trans h-full bg-green"/>
        </div>
    )
}

export default function Steps({children}) {
    function getProgress() {
        console.log(children);
        if (!children || !Array.isArray(children)) return 0;

        // TODO: type-hint item
        let completed = children.reduce((acc, item) => acc + item.props.completed, 0);
        let total = children.length;

        return completed / total;
    }

    return (
        <div className="py-4 my-2 py-4 px-12 flex">
            <div className="relative flex justify-around h-1 w-full">
                <StepProgressBar progress={getProgress()}/>

                {children}
            </div>
        </div>
    );
}