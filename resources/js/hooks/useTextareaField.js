import React from "react";
import {useField} from "react-final-form-hooks";
import useInputField from "./useInputField";

export default function useTextareaField(name, form, props) {
    return useInputField('textarea', name, form, props);
}