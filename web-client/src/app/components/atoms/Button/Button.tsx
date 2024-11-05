import PropTypes from 'prop-types'

export interface IButtonProps {
  children: PropTypes.ReactElementLike | PropTypes.ReactNodeArray
  className?: string
  id?: string
  theme:
    | 'primary'
    | 'secondary'
    | 'accent'
    | 'ghost'
    | 'success'
    | 'error'
    | 'link'
  size?: 'large' | 'medium' | 'small' | 'xsmall'
  outline?: boolean
  type: 'submit' | 'button' | 'reset'
  disabled?: boolean
  onClick?: React.MouseEventHandler<HTMLButtonElement>
}

const buttonApperanceType = {
  primary: 'btn-primary',
  secondary: 'btn-secondary',
  accent: 'btn-accent',
  ghost: 'btn-ghost',
  success: 'btn-success',
  error: 'btn-error',
  link: 'btn-link',
}

const buttonSize = {
  large: 'btn-lg',
  medium: 'btn-md',
  small: 'btn-sm',
  xsmall: 'btn-xs',
}

export const Button = ({
  children,
  className = '',
  theme = 'primary',
  size = 'medium',
  outline = false,
  ...props
}: IButtonProps) => {
  let buttonClasses: string[] | string = []
  if (theme) buttonClasses.push(buttonApperanceType[theme])
  if (size) buttonClasses.push(buttonSize[size])
  if (outline) buttonClasses.push('btn-outline')
  buttonClasses = buttonClasses.join(' ')
  return (
    <button className={`btn ${buttonClasses} ${className}`} {...props}>
      {children}
    </button>
  )
}
